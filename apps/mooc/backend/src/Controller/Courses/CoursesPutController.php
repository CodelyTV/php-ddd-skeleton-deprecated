<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Courses;

use CodelyTv\Mooc\Courses\Application\CourseCreator;
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
        $name     = $request->request->get('name');
        $duration = $request->request->get('duration');

        $this->creator->__invoke($id, $name, $duration);

        return new Response('', Response::HTTP_CREATED);
    }
}
