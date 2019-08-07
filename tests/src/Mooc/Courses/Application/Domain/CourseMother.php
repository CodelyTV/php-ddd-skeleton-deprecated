<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Domain;

use CodelyTv\Mooc\Courses\Application\Create\CreateCourseRequest;
use CodelyTv\Mooc\Courses\Domain\Course;
use CodelyTv\Mooc\Courses\Domain\CourseDuration;
use CodelyTv\Mooc\Courses\Domain\CourseId;
use CodelyTv\Mooc\Courses\Domain\CourseName;

final class CourseMother
{
    public static function create(CourseId $id, CourseName $name, CourseDuration $duration): Course
    {
        return new Course($id, $name, $duration);
    }

    public static function fromRequest(CreateCourseRequest $request): Course
    {
        return self::create(
            CourseIdMother::create($request->id()),
            CourseNameMother::create($request->name()),
            CourseDurationMother::create($request->duration())
        );
    }

    public static function random(): Course
    {
        return self::create(CourseIdMother::random(), CourseNameMother::random(), CourseDurationMother::random());
    }
}
