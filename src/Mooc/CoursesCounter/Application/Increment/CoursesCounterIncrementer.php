<?php

declare(strict_types = 1);

namespace CodelyTv\Mooc\CoursesCounter\Application\Increment;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounter;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterId;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterRepository;
use CodelyTv\Mooc\Shared\Domain\Course\CourseId;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventPublisher;
use CodelyTv\Shared\Domain\UuidGenerator;

final class CoursesCounterIncrementer
{
    private $repository;
    private $uuidGenerator;
    private $publisher;

    public function __construct(
        CoursesCounterRepository $repository,
        UuidGenerator $uuidGenerator,
        DomainEventPublisher $publisher
    ) {
        $this->repository    = $repository;
        $this->uuidGenerator = $uuidGenerator;
        $this->publisher     = $publisher;
    }

    public function __invoke(CourseId $courseId)
    {
        $counter = $this->repository->search() ?: $this->initializeCounter();

        if (!$counter->hasIncremented($courseId)) {
            $counter->increment($courseId);

            $this->repository->save($counter);
            $this->publisher->publish(...$counter->pullDomainEvents());
        }
    }

    private function initializeCounter(): CoursesCounter
    {
        return CoursesCounter::initialize(new CoursesCounterId($this->uuidGenerator->generate()));
    }
}
