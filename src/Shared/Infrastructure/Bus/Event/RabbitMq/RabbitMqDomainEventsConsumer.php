<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPEnvelope;
use AMQPQueue;
use AMQPQueueException;
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
        try {
            $this->connection->queue($queueName)->consume($this->consumer($subscriber));
        } catch (AMQPQueueException $error) {
            // There is a buf with the amqp-1.9.4 version that throws a non-existing error with php 7
        }
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
