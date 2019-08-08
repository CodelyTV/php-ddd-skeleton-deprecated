<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\PhpUnit;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventPublisher;
use PHPUnit\Framework\MockObject\MockObject;

abstract class UnitTestCase
{
    private $domainEventPublisher;

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->domainEventPublisher()->method('publish')->with($domainEvent);
    }

    /** @return DomainEventPublisher|MockObject */
    protected function domainEventPublisher(): MockObject
    {
        return $this->domainEventPublisher = $this->domainEventPublisher
            ?: $this->createMock(DomainEventPublisher::class);
    }
}
