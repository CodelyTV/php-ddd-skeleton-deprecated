<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBus;
use CodelyTv\Shared\Domain\Utils;
use Doctrine\ORM\EntityManager;
use function Lambdish\Phunctional\each;

final class MySqlDoctrineEventBus implements EventBus
{
    private const DATABASE_TIMESTAMP_FORMAT = 'Y-m-d H:i:s';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function publish(DomainEvent ...$domainEvents): void
    {
        each($this->publisher(), $domainEvents);
    }

    private function publisher(): callable
    {
        $connection = $this->entityManager->getConnection();

        return static function (DomainEvent $domainEvent) use ($connection): void {
            $id          = $connection->quote($domainEvent->eventId());
            $aggregateId = $connection->quote($domainEvent->aggregateId());
            $name        = $connection->quote($domainEvent::eventName());
            $body        = $connection->quote(Utils::jsonEncode($domainEvent->toPrimitives()));
            $occurredOn  = $connection->quote(
                Utils::stringToDate($domainEvent->occurredOn())->format(self::DATABASE_TIMESTAMP_FORMAT)
            );

            $connection->executeUpdate(
                <<<SQL
INSERT INTO domain_events (id, aggregate_id, name, body, occurred_on) VALUES ($id, $aggregateId, $name, $body, $occurredOn);
SQL
            );
        };
    }
}
