<?php

namespace CodelyTv\Mooc\User\Infrastructure;

use CodelyTv\Mooc\User\Domain\User;

interface UserWriterRepositoryInterface
{
    public function save(User $user): void;
}