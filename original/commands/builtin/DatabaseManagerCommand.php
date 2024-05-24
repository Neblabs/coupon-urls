<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\App\Credentials\ConsoleCredentials;
use CouponURLs\Original\Data\Drivers\PDODatabaseDriver;
use CouponURLs\Original\Data\Drivers\WordPressDatabaseDriver;
use CouponURLs\Original\Environment\Env;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

Class DatabaseManagerCommand extends Command
{
    protected function configure()
    {
        $this->setName('database');
        $this->setDescription('Manage database structure');

        $this->addArgument('action', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (string) $ApplicationDatabase = Env::settings()->schema->applicationDatabase;

        (object) $applicationDatabase = new $ApplicationDatabase(new PDODatabaseDriver(new ConsoleCredentials));

        (string) $action = $input->getArgument('action');

        $applicationDatabase->{$action}();
    }
}