<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

Class TestFilesCommandCommand extends Command
{
    protected function configure()
    {
        $this->setName('tests.install');
        $this->setDescription('copy premade test files to the temporrary directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo 'copying files to the temporary directory...';

        (string) $wordpressSource = '/Users/rafa/wordpress';
        (string) $wordpressTestsLibSource = '/Users/rafa/wordpress-tests-lib';

        (string) $wordpressTemporaryDir = '/private/var/folders/20/7ymxt5796qbb9vtdl0qbzrt00000gn/T/wordpress';
        (string) $wordpressTestsLibTemporaryDir = '/private/var/folders/20/7ymxt5796qbb9vtdl0qbzrt00000gn/T/wordpress-tests-lib';

        exec("rm -rf $wordpressTemporaryDir");
        exec("rm -rf $wordpressTestsLibTemporaryDir");
        
        exec("`cp -r $wordpressSource $wordpressTemporaryDir`;");

        exec("`cp -r $wordpressTestsLibSource {$wordpressTestsLibTemporaryDir}`;");   

        return 1;
    }
}