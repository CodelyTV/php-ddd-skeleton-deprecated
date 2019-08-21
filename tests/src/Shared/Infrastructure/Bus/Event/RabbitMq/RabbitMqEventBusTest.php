<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMQConnection;
use CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqEventBus;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use CodelyTv\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class RabbitMqEventBusTest extends InfrastructureTestCase
{
    private $publisher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publisher = new RabbitMqEventBus($this->service(RabbitMQConnection::class), 'test_domain_events');
    }

    /** @test */
    public function it_should_publish_domain_events(): void
    {
        $this->publisher->publish(CourseCreatedDomainEventMother::random());
        $this->publisher->publish(CoursesCounterIncrementedDomainEventMother::random());
    }
}
