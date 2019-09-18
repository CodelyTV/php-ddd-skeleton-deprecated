<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Backoffice\Frontend\Controller\Home;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class HomeGetController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request): Response
    {
        return new Response(
            $this->twig->render(
                'pages/home.html.twig',
                [
                    'title'       => 'Welcome',
                    'description' => 'CodelyTV - Backoffice',
                ]
            )
        );
    }
}
