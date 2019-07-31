<?php

declare(strict_types = 1);

namespace CodelyTv\Mooc\Courses\Application;

use CodelyTv\Mooc\Courses\Domain\Course;
use CodelyTv\Mooc\Courses\Domain\CourseRepository;

final class CourseCreator
{
    private $repository;

    public function __construct(CourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id, string $name, string $duration)
    {
        $course = new Course($id, $name, $duration);

        $this->repository->save($course);
    }
}
