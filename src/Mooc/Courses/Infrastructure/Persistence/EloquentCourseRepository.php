<?php

declare(strict_types = 1);

namespace CodelyTv\Mooc\Courses\Infrastructure\Persistence;

use CodelyTv\Mooc\Courses\Domain\Course;
use CodelyTv\Mooc\Courses\Domain\CourseDuration;
use CodelyTv\Mooc\Courses\Domain\CourseName;
use CodelyTv\Mooc\Courses\Domain\CourseRepository;
use CodelyTv\Mooc\Courses\Infrastructure\Persistence\Eloquent\CourseEloquentModel;
use CodelyTv\Mooc\Shared\Domain\Course\CourseId;

final class EloquentCourseRepository implements CourseRepository
{
    public function save(Course $course): void
    {
        $id = $course->id()->value();

        CourseEloquentModel::updateOrCreate(compact('id'), [
            'id' => $id,
            'name' => $course->name()->value(),
            'duration' => $course->duration()->value(),
        ]);
    }

    public function search(CourseId $id): ?Course
    {
        $model = CourseEloquentModel::find($id->value());

        if (null === $model) {
            return null;
        }

        return new Course(new CourseId($model->id), new CourseName($model->name), new CourseDuration($model->duration));
    }
}
