<?php

declare(strict_types = 1);

namespace CodelyTv\Apps\Mooc\Backend\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DemoCommand extends Command
{
    protected static $defaultName = 'codelytv:demo';
    private $searcher;

    protected function configure()
    {
        $this
            ->addArgument('from', InputArgument::REQUIRED, 'Start date')
            ->addArgument('to', InputArgument::REQUIRED, 'End date');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $from = $input->getArgument('from');
        $to   = $input->getArgument('to');

        $output->writeln("$from, $to");
    }
}
