<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\CoursesCounter;

use CodelyTv\Mooc\CoursesCounter\Application\Find\CoursesCounterFinder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CoursesCounterGetController
{
    private $finder;

    public function __construct(CoursesCounterFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke()
    {
        $response = $this->finder->__invoke();

        return new JsonResponse(
            [
                'total' => $response->total(),
            ]
        );
    }
}
