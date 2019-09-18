<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Backoffice\Frontend\Controller\Courses;

use CodelyTv\Mooc\Courses\Application\Create\CreateCourseCommand;
use CodelyTv\Shared\Infrastructure\Symfony\Controller;
use Symfony\Component\HttpFoundation\Request;

final class CoursesPostController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->dispatch(
            new CreateCourseCommand(
                $request->request->get('id'),
                $request->request->get('name'),
                $request->request->get('duration')
            )
        );

        return $this->redirect('courses_get');
    }
}
