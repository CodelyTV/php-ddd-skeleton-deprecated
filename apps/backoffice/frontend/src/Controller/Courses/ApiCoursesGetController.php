<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Backoffice\Frontend\Controller\Courses;

use CodelyTv\Backoffice\Courses\Application\BackofficeCourseResponse;
use CodelyTv\Backoffice\Courses\Application\BackofficeCoursesResponse;
use CodelyTv\Backoffice\Courses\Application\SearchByCriteria\SearchBackofficeCoursesByCriteriaQuery;
use CodelyTv\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function Lambdish\Phunctional\map;

final class ApiCoursesGetController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var BackofficeCoursesResponse $response */
        $response = $this->ask(
            new SearchBackofficeCoursesByCriteriaQuery(
                $request->query->get('filters', []),
                $request->query->get('order_by'),
                $request->query->get('order'),
                $request->query->get('limit'),
                $request->query->get('offset')
            )
        );

        return new JsonResponse(map($this->toArray(), $response->courses()));
    }

    private function toArray(): callable
    {
        return static function (BackofficeCourseResponse $course) {
            return [
                'id'       => $course->id(),
                'name'     => $course->name(),
                'duration' => $course->duration(),
            ];
        };
    }
}
