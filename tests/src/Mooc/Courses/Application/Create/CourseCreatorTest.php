<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Application\Create\CourseCreator;
use CodelyTv\Mooc\Courses\Domain\CourseRepository;
use CodelyTv\Tests\Mooc\Courses\Application\Domain\CourseMother;
use PHPUnit\Framework\TestCase;

final class CourseCreatorTest extends TestCase
{
    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $repository = $this->createMock(CourseRepository::class);
        $creator    = new CourseCreator($repository);

        $request = CreateCourseRequestMother::random();

        $course  = CourseMother::fromRequest($request);

        $repository->method('save')->with($course);

        $creator->__invoke($request);
    }
}
