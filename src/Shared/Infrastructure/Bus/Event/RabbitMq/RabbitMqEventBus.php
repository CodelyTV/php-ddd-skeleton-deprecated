<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBus;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use function Lambdish\Phunctional\each;

final class RabbitMqEventBus implements EventBus
{
    private $connection;
    private $exchangeName;

    public function __construct(RabbitMqConnection $connection, string $exchangeName)
    {
        $this->connection   = $connection;
        $this->exchangeName = $exchangeName;
    }

    public function publish(DomainEvent ...$events): void
    {
        each($this->publisher(), $events);
    }

    private function publisher(): callable
    {
        return function (DomainEvent $event) {
            $serializedEvent = DomainEventJsonSerializer::serialize($event);
            $routingKey      = $event::eventName();
            $messageId       = $event->eventId();

            $this->connection->exchange($this->exchangeName)->publish(
                $serializedEvent,
                $routingKey,
                AMQP_NOPARAM,
                [
                    'message_id'       => $messageId,
                    'content_type'     => 'application/json',
                    'content_encoding' => 'utf-8',
                ]
            );
        };
    }
}
