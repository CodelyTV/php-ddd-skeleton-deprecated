<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConnection;
use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;
use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqEventBus;
use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use CodelyTv\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use RuntimeException;

final class RabbitMqEventBusTest extends InfrastructureTestCase
{
    private $exchangeName;
    private $configurer;
    private $publisher;
    private $consumer;
    private $fakeSubscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = $this->service(RabbitMqConnection::class);

        $this->exchangeName   = 'test_domain_events';
        $this->configurer     = new RabbitMqConfigurer($connection);
        $this->publisher      = new RabbitMqEventBus($connection, $this->exchangeName);
        $this->consumer       = new RabbitMqDomainEventsConsumer(
            $connection,
            $this->service(DomainEventJsonDeserializer::class)
        );
        $this->fakeSubscriber = new TestAllWorksOnRabbitMqEventsPublished();

        $connection->queue(RabbitMqQueueNameFormatter::format($this->fakeSubscriber))->delete();
    }

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_rabbitmq(): void
    {
        $domainEvent = CourseCreatedDomainEventMother::random();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->consumer->consume(
            $this->consumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );
    }

    /** @test */
    public function it_should_throw_an_exception_consuming_non_existing_domain_events(): void
    {
        $this->expectException(RuntimeException::class);

        $domainEvent = CoursesCounterIncrementedDomainEventMother::random();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->consumer->consume(
            $this->consumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );
    }

    private function consumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);
        };
    }
}
