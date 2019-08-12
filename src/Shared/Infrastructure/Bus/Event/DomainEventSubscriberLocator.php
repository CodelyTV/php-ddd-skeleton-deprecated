<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event;

use CodelyTv\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;

final class DomainEventSubscriberLocator
{
    private $mapping;

    public function __construct(iterable $mapping)
    {
        $this->mapping = CallableFirstParameterExtractor::forPipedCallables($mapping);
    }

    public function for(string $eventClass): callable
    {
        return $this->mapping[$eventClass];
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
