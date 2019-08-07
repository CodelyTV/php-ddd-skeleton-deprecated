<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Application\Create\CourseCreator;
use CodelyTv\Mooc\Courses\Application\Create\CreateCourseRequest;
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

        $request = new CreateCourseRequest('some-id', 'some-name', 'some-duration');

        $course = new Course($request->id(), $request->name(), $request->duration());

        $repository->method('save')->with($course);

        $creator->__invoke($request);
    }
}
