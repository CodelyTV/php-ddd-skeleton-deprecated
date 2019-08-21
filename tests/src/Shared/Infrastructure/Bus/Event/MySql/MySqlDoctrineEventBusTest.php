<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Bus\Event\MySql;

use CodelyTv\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use CodelyTv\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

final class MySqlDoctrineEventBusTest extends InfrastructureTestCase
{
    private $publisher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publisher = new MySqlDoctrineEventBus($this->service(EntityManager::class));
    }

    /** @test */
    public function it_should_publish_domain_events(): void
    {
        $this->publisher->publish(CourseCreatedDomainEventMother::random());
        $this->publisher->publish(CoursesCounterIncrementedDomainEventMother::random());
    }
}
