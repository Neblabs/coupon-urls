<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Subscriber\SubscriberFileCreator;
use CouponURLs\Original\Creators\Subscriber\SubscriberRegistratorTask;
use CouponURLs\Original\Creators\Tasks\TestFileCreatorTask;

use function CouponURLs\Original\Utilities\Collection\_;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class SubscriberCreatorCommandCommand extends Command
{
    protected function configure()
    {
        //
        //
        //
        //
        // we need to adapt this to the global, frontend, backend, etc!
        //
        //
        $this->setName('new.subscriber');
        $this->setDescription('Creates and registers a new Subscriber by default in app/events');

        $this->addArgument('subscriberNameNoPrefixWillBeAdded', InputArgument::REQUIRED, 'the name of the subscriber class');

        $this->addArgument(
            name: 'actionHookName', 
            mode: InputArgument::REQUIRED,
            description: 'The name of the hook. If none given, it will not be registered.'
        );

        $this->addArgument(
            name: 'section', 
            mode: InputArgument::REQUIRED,
            description: 'g = global.php | f = frontend.php | b = backend.php'
        );

        $this->addOption('original', null, InputOption::VALUE_NEGATABLE, 'put it in original/subscribers instead of app/subscribers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $subscriberFileCreator = new SubscriberFileCreator(
            subscriberName: $input->getArgument('subscriberNameNoPrefixWillBeAdded'),
            createInOriginal: (boolean) $input->getOption('original')           
        );

        $subscriberFileCreator->registerCompletionTasks(_(
            ($hookName = $input->getArgument('actionHookName'))? new SubscriberRegistratorTask(
                $hookName,
                section: $input->getArgument('section')
            ) : null,
            new TestFileCreatorTask
        )->filter()->asArray());

        $subscriberFileCreator->create();

        return 1;   
    }
}