<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\CreatorCreator;
use CouponURLs\Original\Creators\CreatorsFactory;
use CouponURLs\Original\Creators\ModelFilesCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class CreatorCreatorCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.creator');
        $this->setDescription("Creates a ClassFileCreator class somewhere in the plugin directory (by dfeault in original/creators, use --app to create the files in app/)\n\n Example: edp new.creator validator creates a ValidatorFileCreator.php in original/creators/validator.");

        $this->addArgument('relativePath', InputArgument::REQUIRED, 'relative path (eg): model/domains. By default, it creates it in the original directory. use --app to create it insde /app.');

        $this->addOption('l-base', null, InputOption::VALUE_NONE, "extends the base ProjectFileCreator class. No extra file templates are created. \n");
        $this->addOption('app', null, InputOption::VALUE_NONE, 'creates the files in the /app direactory instead of /original');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $creatorsFactory = new CreatorsFactory(
            $input->getArgument('relativePath'), 
            $this->getLevel($input),
            $input->getOption('app')
        );

        (object) $creatorCreator = $creatorsFactory->create();

        $creatorCreator->create();

        return 1;
    }

    protected function getLevel(InputInterface $input) : string
    {
        switch (true) {
            case $input->getOption('l-base'):
                return CreatorsFactory::BASE;
                break;
            default:
                return CreatorsFactory::TEMPLATE;
                break;
        }
    }
    
}