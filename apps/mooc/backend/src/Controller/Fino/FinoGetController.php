<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Fino;

use CodelyTv\Shared\Domain\CurrentDateGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FinoGetController
{
    private $date;

    public function __construct(CurrentDateGenerator $date)
    {
        $this->date = $date->generate();
    }

    public function __invoke(Request $request): Response
    {
        $name = $request->get('name');
        return new JsonResponse(
            [
                'desc' => 'Todo va fino ' . $name,
                'date' => $this->date,
            ]
        );
    }
}