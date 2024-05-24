<?php

namespace CouponURLs\App\Commands;

use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Subscriber;
use League\CLImate\CLImate;
use ReflectionClass;
use stdClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function CouponURLs\Original\Utilities\Text\i;

Class QuickConsolePlaygroundCommand extends Command
{
    protected function configure()
    {
        $this->setName('play');
        $this->setDescription('Generic console playground for quick tests.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $export = <<<Array
        return [
            'init' => [
                'App\\Coupons\\Email',
                'App\\Coupons\\Actions'
            ],
            'do_ref_array' => [
            ],
        ]
        Array;

        dump(i($export)->replaceRegEx("/'(\w+)' =>/", '$1:')->replace('return [', 'return a(')->trimRight()->removeRight(']')->ensureRight(')'));
        return 0;
    }
}

/*
class a {
    function func(): mixed {

    }
}

class b extends a {
    protected b $a;

    function func() : int {

    }
}*/