<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Domain\Bus;

interface DomainEventPublisher
{
    public function publish(DomainEvent ...$domainEvents);
}
