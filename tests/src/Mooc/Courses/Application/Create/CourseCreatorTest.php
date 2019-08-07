<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Application\Create\CourseCreator;
use CodelyTv\Tests\Mooc\Courses\Application\Domain\CourseCreatedDomainEventMother;
use CodelyTv\Tests\Mooc\Courses\Application\Domain\CourseMother;
use CodelyTv\Tests\Mooc\Courses\CoursesModuleUnitTestCase;

final class CourseCreatorTest extends CoursesModuleUnitTestCase
{
    private $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new CourseCreator($this->repository());
    }

    /** @test */
    public function it_should_create_a_valid_course(): void
    {
        $request = CreateCourseRequestMother::random();

        $course      = CourseMother::fromRequest($request);
        $domainEvent = CourseCreatedDomainEventMother::fromCourse($course);

        $this->shouldSave($course);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->creator->__invoke($request);
    }
}
