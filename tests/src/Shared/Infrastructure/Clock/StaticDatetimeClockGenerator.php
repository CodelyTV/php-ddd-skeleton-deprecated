<?php

namespace CodelyTv\Tests\Shared\Infrastructure\Clock;

use CodelyTv\Shared\Domain\ClockInterface;

class StaticDatetimeClockGenerator implements ClockInterface
{
    public function getDateTime(): string
    {
        return '2020-01-01 00:00:00';
    }
}