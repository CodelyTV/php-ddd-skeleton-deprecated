<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application;

use CodelyTv\Mooc\Courses\Application\CourseCreator;
use CodelyTv\Mooc\Courses\Domain\Course;
use CodelyTv\Mooc\Courses\Domain\CourseRepository;
use PHPUnit\Framework\TestCase;

final class CourseCreatorTest extends TestCase
{
    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $repository = $this->createMock(CourseRepository::class);
        $creator    = new CourseCreator($repository);

        $id       = 'some-id';
        $name     = 'some-name';
        $duration = 'some-duration';

        $course = new Course($id, $name, $duration);

        $repository->method('save')->with($course);

        $creator->__invoke($id, $name, $duration);
    }
}
