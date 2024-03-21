<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure;

use CodelyTv\Shared\Domain\CurrentDateGenerator;

final class ConstantCurrentDateGenerator implements CurrentDateGenerator
{
    public function generate(): string
    {
        return "2020-01-01 00:00:00";
    }
}
