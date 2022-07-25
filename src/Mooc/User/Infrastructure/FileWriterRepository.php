<?php

namespace CodelyTv\Mooc\User\Infrastructure;

use CodelyTv\Mooc\User\Domain\User;

class FileWriterRepository implements UserWriterRepositoryInterface
{
    private const FILENAME = '/tmp/users.txt';

    public function save(string $name, string $email): User
    {
        $id = $this->getLastId() + 1;
        file_put_contents(self::FILENAME, "$id,$name,$email\n", FILE_APPEND);
        return new User($id, $name, $email);
    }

    private function getLastId(): int
    {
        $line = $this->getLastLine();
        if ($line === null) {
            return 0;
        }

        $chunks = explode(',', $line);
        $id = $chunks[0] ?? 0;
        return is_numeric($id)
            ? (int)$id
            : 0;
    }

    private function getLastLine(): ?string
    {
        $lines = file(self::FILENAME);
        return array_pop($lines) ?: null;
    }
}