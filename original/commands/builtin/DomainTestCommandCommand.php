<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Environment\Env;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class DomainTestCommandCommand extends Command
{
    protected function configure()
    {
        $this->setName('test.domain');
        $this->setDescription('Tests all Entity and Entities.');

        $this->addArgument('EntityName', InputArgument::OPTIONAL, 'eg: Post');
        //$this->addOption('app', null, InputOption::VALUE_NONE, 'the very useful description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (string) $php = Env::settings()->binaries->php;
        (string) $phpunit = Env::settings()->binaries->phpunit;
        (string) $wahtToRun = $input->getArgument('EntityName') ? "--filter {$input->getArgument('EntityName')}" : 'tests/unit/app/domain/.';
        system("{$php} {$phpunit} {$wahtToRun} --verbose --colors=always");
    }
}