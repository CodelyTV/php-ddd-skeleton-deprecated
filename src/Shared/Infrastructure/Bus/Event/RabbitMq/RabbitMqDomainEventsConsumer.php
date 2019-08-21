<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPEnvelope;
use AMQPQueue;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;

final class RabbitMqDomainEventsConsumer
{
    private $connection;
    private $deserializer;

    public function __construct(RabbitMqConnection $connection, DomainEventJsonDeserializer $deserializer)
    {
        $this->connection   = $connection;
        $this->deserializer = $deserializer;
    }

    public function consume(callable $subscriber, string $queueName): void
    {
        $this->connection->queue($queueName)->consume($this->consumer($subscriber));
    }

    private function consumer(callable $subscriber): callable
    {
        return function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($subscriber) {
            $event = $this->deserializer->deserialize($envelope->getBody());

            $subscriber($event);

            $queue->ack($envelope->getDeliveryTag());
        };
    }
}
