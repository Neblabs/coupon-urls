<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Dependency\DependencyFileCreator;
use CouponURLs\Original\Creators\Dependency\DependencyRegistratorTask;
use CouponURLs\Original\Creators\Tasks\TestFileCreatorTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

Class DependencyCreatorCommandCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.dependency');
        $this->setDescription('Creates and registers a new Dependency in app/dependencies by default');

        $this->addArgument(
            name: 'DependencyClassNameNoPrefix', 
            mode: InputArgument::REQUIRED, 
            description: 'Example: Subscribers -> will create SubscribersDependency'
        );

        $this->addOption('original', null, InputOption::VALUE_NEGATABLE, 'create inside original/ instead of app/');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $dependencyFileCreator = new DependencyFileCreator(
            $input->getArgument(name: 'DependencyClassNameNoPrefix'),
            (boolean) $input->getOption(name: 'original')
        );

        $dependencyFileCreator->registerCompletionTasks([
            new DependencyRegistratorTask,
            new TestFileCreatorTask
        ]);

        $dependencyFileCreator->create();

        return 1;
    }
}