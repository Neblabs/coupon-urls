<?php

namespace CouponURLS\Original\Deployment\Scripts;

use CouponURLS\Original\Deployment\Script;
use CouponURLS\Original\Environment\Env;

Class PHPFormatCompilerScript extends Script
{
    public function run()
    {
        (string) $copyDirectoryName = $this->data->get('copyDirectoryName');
        (string) $command = Env::directory()."vendor/bin/ecs check {$copyDirectoryName} --fix";

        print "\nFormatting...\n";
        (string) $outPut = shell_exec($command);

        print $outPut;
    }
    
}