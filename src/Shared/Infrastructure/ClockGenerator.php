<?php

namespace CodelyTv\Shared\Infrastructure;

use CodelyTv\Shared\Domain\ClockInterface;

final class ClockGenerator implements ClockInterface
{
    private $time;

    public function __construct()
    {
        $this->time = time();
    }

    public function getDateTime(): string
    {
        return date('Y-m-d H:i:s', $this->time);
    }
}