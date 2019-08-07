<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Application\Create\CourseCreator;
use CodelyTv\Mooc\Courses\Application\Create\CreateCourseRequest;
use CodelyTv\Mooc\Courses\Domain\Course;
use CodelyTv\Mooc\Courses\Domain\CourseDuration;
use CodelyTv\Mooc\Courses\Domain\CourseId;
use CodelyTv\Mooc\Courses\Domain\CourseName;
use CodelyTv\Mooc\Courses\Domain\CourseRepository;
use PHPUnit\Framework\TestCase;

final class CourseCreatorTest extends TestCase
{
    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $repository = $this->createMock(CourseRepository::class);
        $creator    = new CourseCreator($repository);

        $request = new CreateCourseRequest('decf33ca-81a7-419f-a07a-74f214e928e5', 'some-name', 'some-duration');

        $course = new Course(
            new CourseId($request->id()),
            new CourseName($request->name()),
            new CourseDuration($request->duration())
        );

        $repository->method('save')->with($course);

        $creator->__invoke($request);
    }
}
