<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Greet;

use CodelyTv\Shared\Infrastructure\GreetGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GreetGetController
{
    private $generator;

    public function __construct(GreetGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function __invoke(Request $request): Response
    {
        $name = $request->get('name');
        return new JsonResponse(
            [
                'mooc-backend' => 'ok',
                'message'      => $this->generator->generate($name),
                'date'         => date('Y-m-d h:i:s')
            ]
        );
    }
}