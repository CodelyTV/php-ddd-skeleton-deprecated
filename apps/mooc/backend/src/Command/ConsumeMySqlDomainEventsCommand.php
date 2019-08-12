<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Command;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;
use CodelyTv\Shared\Infrastructure\Bus\Event\DoctrineDomainEventsConsumer;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use CodelyTv\Tests\Shared\Infrastructure\Doctrine\DatabaseConnections;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Lambdish\Phunctional\pipe;

final class ConsumeMySqlDomainEventsCommand extends Command
{
    protected static $defaultName = 'codelytv:consume-domain-events:mysql';
    private $consumer;
    private $subscriberLocator;
    private $connections;

    public function __construct(
        DoctrineDomainEventsConsumer $consumer,
        DatabaseConnections $connections,
        DomainEventSubscriberLocator $subscriberLocator
    ) {
        $this->consumer          = $consumer;
        $this->subscriberLocator = $subscriberLocator;
        $this->connections       = $connections;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume domain events from MySql')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of events to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var int $quantityEventsToProcess */
        $quantityEventsToProcess = (int) $input->getArgument('quantity');

        $consumer = pipe($this->consumer(), $this->clearConnections());

        $this->consumer->consume($consumer, $quantityEventsToProcess);
    }

    private function consumer(): callable
    {
        return static function (DomainEvent $domainEvent) {
            $subscribers = $this->subscriberLocator->for(get_class($domainEvent));

            foreach ($subscribers as $subscriber) {
                $subscriber($domainEvent);
            }
        };
    }

    private function clearConnections(): callable
    {
        return function () {
            $this->connections->clear();
        };
    }
}
