<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Application\Create\CreateCourseRequest;
use CodelyTv\Mooc\Courses\Domain\CourseDuration;
use CodelyTv\Mooc\Courses\Domain\CourseName;
use CodelyTv\Mooc\Shared\Domain\Course\CourseId;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseDurationMother;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseIdMother;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseNameMother;

final class CreateCourseRequestMother
{
    public static function create(CourseId $id, CourseName $name, CourseDuration $duration): CreateCourseRequest
    {
        return new CreateCourseRequest($id->value(), $name->value(), $duration->value());
    }

    public static function random(): CreateCourseRequest
    {
        return self::create(CourseIdMother::random(), CourseNameMother::random(), CourseDurationMother::random());
    }
}
