<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Domain\Bus\Event;

interface DomainEventSerializer
{
    public function serialize(DomainEvent $domainEvent): string;
}
