<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure;

class GreetGenerator
{
    public function generate(string $name): string
    {
        return "Todo va fino {$name}";
    }
}