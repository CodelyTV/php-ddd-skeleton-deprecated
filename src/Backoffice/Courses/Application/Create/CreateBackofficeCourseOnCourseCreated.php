<?php

declare(strict_types = 1);

namespace CodelyTv\Backoffice\Courses\Application\Create;

use CodelyTv\Backoffice\Courses\Domain\BackofficeCourse;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepository;
use CodelyTv\Mooc\Courses\Domain\CourseCreatedDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CreateBackofficeCourseOnCourseCreated implements DomainEventSubscriber
{
    private $repository;

    public function __construct(BackofficeCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function subscribedTo(): array
    {
        return [CourseCreatedDomainEvent::class];
    }

    public function __invoke(CourseCreatedDomainEvent $event)
    {
        $this->repository->save(new BackofficeCourse($event->aggregateId(), $event->name(), $event->duration()));
    }
}
