<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventUnserializer;
use CodelyTv\Shared\Infrastructure\Bus\Event\InMemorySymfonyEventBus;
use CodelyTv\Shared\Infrastructure\Doctrine\DatabaseConnections;

final class ApplicationFeatureContext implements Context
{
    private $connections;
    private $publisher;
    private $bus;
    private $unserializer;

    public function __construct(
        DatabaseConnections $connections,
        InMemorySymfonyEventBus $bus,
        DomainEventUnserializer $unserializer
    ) {
        $this->connections  = $connections;
        $this->bus          = $bus;
        $this->unserializer = $unserializer;
    }

    /** @BeforeScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }

    /**
     * @Given /^I send an event to the event bus:$/
     */
    public function iSendAnEventToTheEventBus(PyStringNode $event)
    {
        $domainEvent = $this->unserializer->unserialize($event->getRaw());

        $this->bus->publish($domainEvent);
    }
}
