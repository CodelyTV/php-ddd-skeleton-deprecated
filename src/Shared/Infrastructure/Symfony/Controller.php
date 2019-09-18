<?php

declare(strict_types = 1);

namespace CodelyTv\Shared\Infrastructure\Symfony;

use CodelyTv\Shared\Domain\Bus\Command\Command;
use CodelyTv\Shared\Domain\Bus\Command\CommandBus;
use CodelyTv\Shared\Domain\Bus\Query\Query;
use CodelyTv\Shared\Domain\Bus\Query\QueryBus;
use CodelyTv\Shared\Domain\Bus\Query\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

abstract class Controller
{
    private $twig;
    private $router;
    private $queryBus;
    private $commandBus;

    public function __construct(Environment $twig, RouterInterface $router, QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->twig       = $twig;
        $this->router     = $router;
        $this->queryBus   = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function render(string $templatePath, array $arguments = []): SymfonyResponse
    {
        return new SymfonyResponse($this->twig->render($templatePath, $arguments));
    }

    public function redirect(string $routeName): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($routeName), 302);
    }

    public function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
