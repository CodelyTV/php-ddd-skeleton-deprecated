<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Mooc\CoursesCounter;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounter;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterRepository;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class CoursesCounterModuleUnitTestCase extends UnitTestCase
{
    private $repository;

    protected function shouldSave(CoursesCounter $course): void
    {
        $this->repository()->method('save')->withAnyParameters();
    }

    protected function shouldSearch(?CoursesCounter $counter): void
    {
        $this->repository()->method('search')->willReturn($counter);
    }

    /** @return CoursesCounterRepository|MockObject */
    protected function repository(): MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(CoursesCounterRepository::class);
    }
}
