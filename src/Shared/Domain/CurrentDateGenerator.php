<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Domain;

interface CurrentDateGenerator
{
    public function generate(): string;
}