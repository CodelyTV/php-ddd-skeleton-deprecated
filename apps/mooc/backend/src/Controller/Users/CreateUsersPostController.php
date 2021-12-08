<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Users;

use CodelyTv\Mooc\User\Application\CreateUserRequest;
use CodelyTv\Mooc\User\Application\CreateUserUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateUsersPostController
{
    private $createUserUseCase;

    public function __construct(CreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
    }

    public function __invoke(string $id, Request $request): Response
    {
        $this->createUserUseCase->__invoke(
            new CreateUserRequest(
                $id,
                $request->request->get('name'),
                $request->request->get('email')
            )
        );

        return new Response('', Response::HTTP_CREATED);
    }
}