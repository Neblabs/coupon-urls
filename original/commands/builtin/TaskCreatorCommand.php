<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Task\TaskFileCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class TaskCreatorCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.task');
        $this->setDescription('Creates a new Task file by default in app/tasks, butyou can specify a custom relative directory using --dir');

        $this->addArgument('taskNameNoSuffix', InputArgument::REQUIRED, 'the class name of the task, a Task suffix will be added.');
        $this->addOption('dir', null, InputOption::VALUE_REQUIRED, 'the relative directory for this file to be created. Default: app/tasks', $default = 'app/tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $taskFileCreator = new TaskFileCreator(
            $input->getArgument('taskNameNoSuffix'),
            $input->getOption('dir')
        );

        $taskFileCreator->create();

        return 1;
    }
}