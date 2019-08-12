<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Bus\Event;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Infrastructure\Bus\Event\DoctrineDomainEventPublisher;
use CodelyTv\Shared\Infrastructure\Bus\Event\DoctrineDomainEventsConsumer;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use CodelyTv\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

final class DoctrineDomainEventsConsumerTest extends InfrastructureTestCase
{
    private $publisher;
    private $consumer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publisher = new DoctrineDomainEventPublisher($this->service(EntityManager::class));
        $this->consumer  = new DoctrineDomainEventsConsumer(
            $this->service(EntityManager::class),
            $this->service(DomainEventMapping::class)
        );
    }

    /** @test */
    public function it_should_publish_domain_events(): void
    {
        $domainEvent        = CourseCreatedDomainEventMother::random();
        $anotherDomainEvent = CoursesCounterIncrementedDomainEventMother::random();

        $this->publisher->publish($domainEvent, $anotherDomainEvent);

        $this->consumer->consume($this->consumer($domainEvent, $anotherDomainEvent), 2);
    }

    private function consumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);
        };
    }
}
