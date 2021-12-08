<?php

namespace CodelyTv\Mooc\User\Domain;

class User
{
    private $name;
    private $email;
    private $id;

    public function __construct(UserId $id, UserName $name, UserEmail $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function __toString()
    {
        return implode(',', [$this->id->value(), $this->name->value(), $this->email->value()]);
    }
}