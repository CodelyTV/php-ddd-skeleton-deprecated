<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSerializer;

final class DomainEventJsonSerializer implements DomainEventSerializer
{
    public function serialize(DomainEvent $domainEvent): string
    {
        return json_encode(
            [
                'data' => [
                    'id'          => $domainEvent->eventId(),
                    'type'        => $domainEvent::eventName(),
                    'occurred_on' => $domainEvent->occurredOn(),
                    'attributes'  => array_merge($domainEvent->toPrimitives(), ['id' => $domainEvent->aggregateId()]),
                ],
                'meta' => [],
            ]
        );
    }
}
