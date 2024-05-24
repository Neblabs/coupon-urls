<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Deployment\Builder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

Class BuildManagerCommand extends Command
{
    protected function configure()
    {
        $this->setName('build');
        $this->setDescription('Creates a compressed production version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $builder = new Builder($output);

        $builder->build();

        return 1;
    }
}