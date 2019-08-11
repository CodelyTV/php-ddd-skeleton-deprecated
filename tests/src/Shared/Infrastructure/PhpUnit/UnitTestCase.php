<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\PhpUnit;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventPublisher;
use CodelyTv\Shared\Domain\UuidGenerator;
use CodelyTv\Tests\Shared\Domain\TestUtils;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\MatcherAbstract;
use Mockery\MockInterface;

abstract class UnitTestCase extends MockeryTestCase
{
    private $domainEventPublisher;
    private $uuidGenerator;

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->domainEventPublisher()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->andReturnNull();
    }

    /** @return DomainEventPublisher|MockInterface */
    protected function domainEventPublisher(): MockInterface
    {
        return $this->domainEventPublisher = $this->domainEventPublisher ?: $this->mock(DomainEventPublisher::class);
    }

    protected function shouldGenerateUuid(string $uuid): void
    {
        $this->uuidGenerator()
            ->shouldReceive('generate')
            ->once()
            ->withNoArgs()
            ->andReturn($uuid);
    }

    /** @return UuidGenerator|MockInterface */
    protected function uuidGenerator(): MockInterface
    {
        return $this->uuidGenerator = $this->uuidGenerator ?: $this->mock(UuidGenerator::class);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }

    protected function isSimilar($expected, $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function similarTo($value, $delta = 0.0): MatcherAbstract
    {
        return TestUtils::similarTo($value, $delta);
    }
}
