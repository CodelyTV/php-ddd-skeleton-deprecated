<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event;

use CodelyTv\Shared\Domain\Utils;
use DateTimeImmutable;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManager;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;

final class DoctrineDomainEventsConsumer
{
    private $entityManager;
    private $eventMapping;

    public function __construct(EntityManager $entityManager, DomainEventMapping $eventMapping)
    {
        $this->entityManager = $entityManager;
        $this->eventMapping  = $eventMapping;
    }

    public function consume(callable $subscriber, int $totalEvents): void
    {
        $connection = $this->entityManager->getConnection();

        $events = $connection->executeQuery("SELECT * FROM domain_events ORDER BY occurred_on ASC LIMIT $totalEvents")
            ->fetchAll(FetchMode::ASSOCIATIVE);

        each($this->executeSubscriber($subscriber), $events);

        $ids = implode(', ', map($this->idExtractor(), $events));

        $connection->executeUpdate("DELETE FROM domain_events WHERE id IN ($ids)");
    }

    private function executeSubscriber(callable $subscriber): callable
    {
        return function (array $rawEvent) use ($subscriber) {
            try {
                $domainEventClass = $this->eventMapping->for($rawEvent['name']);
                $domainEvent      = $domainEventClass::fromPrimitives(
                    $rawEvent['aggregate_id'],
                    Utils::jsonDecode($rawEvent['body']),
                    $rawEvent['id'],
                    $this->formatDate($rawEvent['occurred_on'])
                );

                $subscriber($domainEvent);
            } catch (\RuntimeException $error) {
            }
        };
    }

    private function formatDate($stringDate): string
    {
        return Utils::dateToString(new DateTimeImmutable($stringDate));
    }

    private function idExtractor(): callable
    {
        return static function (array $event) {
            return "'${event['id']}'";
        };
    }
}
