<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure;

use CodelyTv\Shared\Domain\CurrentDateGenerator;

final class PhpCurrentDateGenerator implements CurrentDateGenerator
{
    public function generate(): string
    {
        return date('Y-m-d H:i:s', strtotime('now'));
    }
}
