<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Courses;

use CodelyTv\Mooc\Courses\Application\Create\CourseCreator;
use CodelyTv\Mooc\Courses\Application\Create\CreateCourseRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CoursesPutController
{
    private $creator;

    public function __construct(CourseCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(string $id, Request $request)
    {
        $this->creator->__invoke(
            new CreateCourseRequest(
                $id,
                $request->request->get('name'),
                $request->request->get('duration')
            )
        );

        return new Response('', Response::HTTP_CREATED);
    }
}
