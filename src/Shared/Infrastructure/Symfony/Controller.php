<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Symfony;

use CodelyTv\Shared\Domain\Bus\Query\Query;
use CodelyTv\Shared\Domain\Bus\Query\QueryBus;
use CodelyTv\Shared\Domain\Bus\Query\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Twig\Environment;

abstract class Controller
{
    private $twig;
    private $queryBus;

    public function __construct(Environment $twig, QueryBus $queryBus)
    {
        $this->twig     = $twig;
        $this->queryBus = $queryBus;
    }

    public function render(string $templatePath, array $arguments = []): SymfonyResponse
    {
        return new SymfonyResponse($this->twig->render($templatePath, $arguments));
    }

    public function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }
}
