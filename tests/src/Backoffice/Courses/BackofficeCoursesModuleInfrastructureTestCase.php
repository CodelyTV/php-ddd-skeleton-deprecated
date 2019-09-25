<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Backoffice\Courses;

use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepository;
use CodelyTv\Tests\Mooc\Shared\Infrastructure\PhpUnit\MoocContextInfrastructureTestCase;

abstract class BackofficeCoursesModuleInfrastructureTestCase extends MoocContextInfrastructureTestCase
{
    protected function repository(): BackofficeCourseRepository
    {
        return $this->service(BackofficeCourseRepository::class);
    }
}
