<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Command;

use CodelyTv\Shared\Infrastructure\Bus\Event\DoctrineDomainEventsConsumer;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use CodelyTv\Shared\Infrastructure\Bus\Event\SubscribersMapping;
use CodelyTv\Shared\Infrastructure\RabbitMQ\RabbitMQDomainEventConsumer;
use CodelyTv\Tests\Shared\Infrastructure\Doctrine\DatabaseConnections;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\pipe;
use function Lambdish\Phunctional\repeat;

final class ConsumeRabbitMQDomainEventsCommand extends Command
{
    protected static $defaultName = 'codelytv:consume-domain-events:rabbitmq';
    private $consumer;
    private $mapping;
    private $connections;

    public function __construct(
        RabbitMQDomainEventConsumer $consumer,
        SubscribersMapping $mapping,
        DatabaseConnections $connections
    ) {
        parent::__construct();

        $this->consumer    = $consumer;
        $this->mapping     = $mapping;
        $this->connections = $connections;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume domain events from RabbitMQ')
            ->addArgument('subscriber', InputArgument::REQUIRED, 'Subscriber to process')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of events to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $subscriberName          = (string) $input->getArgument('subscriber');
        $quantityEventsToProcess = (int) $input->getArgument('quantity');

        repeat(
            pipe($this->consumer($subscriberName), $this->connections->allConnectionsClearer()),
            $quantityEventsToProcess
        );
    }

    private function consumer(string $subscriberName): callable
    {
        return function () use ($subscriberName) {
            apply($this->consumer, [$this->mapping->byName($subscriberName), $subscriberName]);
        };
    }
}
