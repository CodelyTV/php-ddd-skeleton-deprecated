<?php

declare(strict_types = 1);

namespace CodelyTv\Mooc\CoursesCounter\Application\Find;

final class CoursesCounterResponse
{
    private $total;

    public function __construct(int $total)
    {
        $this->total = $total;
    }

    public function total(): int
    {
        return $this->total;
    }
}
