<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Domain\Bus\Event;

interface DomainEventPublisher
{
    public function publish(DomainEvent ...$domainEvents): void;
}
