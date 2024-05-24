<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Tasks\TestFileCreatorTask;
use CouponURLs\Original\Creators\Validator\ValidatorFileCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class ValidatorCreatorCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.validator');
        $this->setDescription("Creates a new Validator file in a validator/ directory relative to the base directory.".
            "\n\nExample:\n".
            "edp new.validator NotNull app/domain/emails"
            ."\n will create a app/domain/emails/validators/NotNull.php");

        $this->addArgument('validatorClassName', InputArgument::REQUIRED, 'Validator class name. No suffix will be added, so you can choose to manually add it or not, depending on your style.');
        $this->addArgument('basePath', InputArgument::REQUIRED, 'the base path relative to the root of the project. a /validators directry will be appended to the end of this base path.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $ValidatorCreator = new ValidatorFileCreator(
            $input->getArgument('validatorClassName'),
            $input->getArgument('basePath')
        );   

        $ValidatorCreator->registerCompletionTasks([
            new TestFileCreatorTask
        ]);

        $ValidatorCreator->create();

        return 1;
    }
}