<?php

namespace CodelyTv\Mooc\User\Application;

use CodelyTv\Mooc\User\Infrastructure\UserWriterRepositoryInterface;
use CodelyTv\Mooc\User\Domain\User;

class CreateUserUseCase
{
    private $repository;

    public function __construct(UserWriterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $name, string $email): User
    {
        return $this->repository->save($name, $email);
    }
}