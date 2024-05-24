<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Handler\HandlerFileCreator;
use CouponURLs\Original\Creators\Handler\HandlerRegistratorTask;
use CouponURLs\Original\Creators\ModelFilesCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

Class HandlerCreatorCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.handler');
        $this->setDescription('Creates a handler in app/handlers');

        $this->addArgument('handlerNameNoSuffix', InputArgument::REQUIRED, 'The name of the handler, a Hanlder suffix will be appended to the name');
        $this->addArgument('hookName', InputArgument::REQUIRED, 'the name of the hook. Eg: init');
        $this->addArgument('hookPriority', InputArgument::OPTIONAL, 'the priority of the hook. Deafult: 10', $default = 10);
        $this->addArgument('hookNumberOfArguments', InputArgument::OPTIONAL, 'the number of arguments of the hook. Default: 3', $default = 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $handlerCreator = new HandlerFileCreator(
            $input->getArgument('handlerNameNoSuffix'),
            $input->getArgument('hookName'),
            $input->getArgument('hookPriority'),
            $input->getArgument('hookNumberOfArguments')
        );

        $handlerCreator->registerCompletionTasks([
            new HandlerRegistratorTask
        ]);

        $handlerCreator->create();
    }
}