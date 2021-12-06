<?php

namespace CodelyTv\Shared\Domain;

interface ClockInterface
{
    public function getDateTime(): string;
}