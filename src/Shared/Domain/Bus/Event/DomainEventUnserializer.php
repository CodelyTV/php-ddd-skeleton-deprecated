<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Domain\Bus\Event;

interface DomainEventUnserializer
{
    public function unserialize(string $domainEvent): DomainEvent;
}
