<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\Courses;

use CodelyTv\Mooc\Courses\Infrastructure\Persistence\FileCourseRepository;
use PHPUnit\Framework\TestCase;

abstract class CoursesModuleInfrastructureTestCase extends TestCase
{
    protected function repository(): FileCourseRepository
    {
        return new FileCourseRepository();
    }
}
