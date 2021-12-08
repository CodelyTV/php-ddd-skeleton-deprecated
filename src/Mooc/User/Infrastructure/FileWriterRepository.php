<?php

namespace CodelyTv\Mooc\User\Infrastructure;

use CodelyTv\Mooc\User\Domain\User;

class FileWriterRepository implements UserWriterRepositoryInterface
{
    private const FILENAME = '/tmp/users.txt';

    public function save(User $user): void
    {
        $userString = (string)$user;
        file_put_contents(self::FILENAME, "$userString\n", FILE_APPEND);
    }
}