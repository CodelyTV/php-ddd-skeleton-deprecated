<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use CodelyTv\Shared\Domain\Bus\DomainEvent;
use CodelyTv\Shared\Domain\Bus\SymfonySyncDomainEventPublisher;
use CodelyTv\Shared\Infrastructure\Bus\Event\SymfonySyncEventBus;
use CodelyTv\Tests\Shared\Infrastructure\Doctrine\DatabaseConnections;
use function Lambdish\Phunctional\each;

final class FeatureContext implements Context
{
    private $connections;
    private $publisher;
    private $bus;

    public function __construct(
        DatabaseConnections $connections,
        SymfonySyncDomainEventPublisher $publisher,
        SymfonySyncEventBus $bus
    ) {
        $this->connections = $connections;
        $this->publisher   = $publisher;
        $this->bus         = $bus;
    }

    /** @BeforeScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }

    /** @AfterStep */
    public function publishEvents(): void
    {
        while ($this->publisher->hasEventsToPublish()) {
            each(
                function (DomainEvent $event) {
                    $this->bus->notify($event);
                },
                $this->publisher->popPublishedEvents()
            );
        }
    }
}
