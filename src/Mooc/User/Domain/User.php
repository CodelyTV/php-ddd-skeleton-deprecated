<?php

namespace CodelyTv\Mooc\User\Domain;

class User
{
    private $name;
    private $email;
    private $id;

    public function __construct(int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}