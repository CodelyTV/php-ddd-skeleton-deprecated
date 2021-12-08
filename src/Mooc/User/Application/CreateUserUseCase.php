<?php

namespace CodelyTv\Mooc\User\Application;

use CodelyTv\Mooc\User\Domain\UserEmail;
use CodelyTv\Mooc\User\Domain\UserId;
use CodelyTv\Mooc\User\Domain\UserName;
use CodelyTv\Mooc\User\Infrastructure\UserWriterRepositoryInterface;
use CodelyTv\Mooc\User\Domain\User;

class CreateUserUseCase
{
    private $repository;

    public function __construct(UserWriterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateUserRequest $request): void
    {
        $user = new User(
            new UserId($request->id()),
            new UserName($request->name()),
            new UserEmail($request->email())
        );
        $this->repository->save($user);
    }
}