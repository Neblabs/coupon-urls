<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Command\CommandFileCreator;
use CouponURLs\Original\Creators\Command\CommandRegistratorTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class CommandCreatorCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.command');
        $this->setDescription('Creates *and registers* a console command, by default in original/, use --app to create it in app/. IMPORTANT!, ALL ELEMENTS IN THE REGISTER ARRAY MUST HAVE A COMMA, INCLUDING THE LAST ELEMENT, IN ORDER FOR THE COMMAND TO BE REGISTERED.');

        $this->addArgument('commandNameNoSuffix', InputArgument::REQUIRED, 'The name of the command class, a Command suffix will be appended to the name.');
        $this->addOption('app', null, InputOption::VALUE_NONE, 'creates the files in the /app direactory instead of /original');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $commandFileCreator = new CommandFileCreator(
            $input->getArgument('commandNameNoSuffix'),
            $input->getOption('app')
        );

        $commandFileCreator->registerCompletionTasks([
            new CommandRegistratorTask
        ]);

        $commandFileCreator->create();

        return 1;
    }
}