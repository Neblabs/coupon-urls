<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

Class {$className} extends Command
{
    protected function configure()
    {
        \$this->setName('new.handler');
        \$this->setDescription('');

        \$this->addArgument('handlerNameNoSuffix', InputArgument::REQUIRED, 'the very useful description');
        \$this->addOption('app', null, InputOption::VALUE_NONE, 'the very useful description');
    }

    protected function execute(InputInterface \$input, OutputInterface \$output)
    {
        return 1;        
    }
}
TEMPLATE;
