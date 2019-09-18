<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

abstract class Controller
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $templatePath, array $arguments = []): Response
    {
        return new Response($this->twig->render($templatePath, $arguments));
    }
}
