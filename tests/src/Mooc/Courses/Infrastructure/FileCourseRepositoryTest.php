<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Infrastructure;

use CodelyTv\Mooc\Courses\Infrastructure\FileCourseRepository;
use CodelyTv\Tests\Mooc\Courses\Application\Domain\CourseIdMother;
use CodelyTv\Tests\Mooc\Courses\Application\Domain\CourseMother;
use PHPUnit\Framework\TestCase;

final class FileCourseRepositoryTest extends TestCase
{
    /** @test */
    public function it_should_save_a_course(): void
    {
        $repository = new FileCourseRepository();
        $course     = CourseMother::random();

        $repository->save($course);
    }

    /** @test */
    public function it_should_return_an_existing_course(): void
    {
        $repository = new FileCourseRepository();
        $course     = CourseMother::random();

        $repository->save($course);

        $this->assertEquals($course, $repository->search($course->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_course(): void
    {
        $repository = new FileCourseRepository();

        $this->assertNull($repository->search(CourseIdMother::random()));
    }
}
