<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Deployment\Script;
use CouponURLs\Original\Environment\Env;

Class PHPDowngradeCompilerScript extends Script
{
    public function run()
    {
        (string) $copyDirectoryName = $this->data->get('copyDirectoryName');
        (string) $command = Env::directory()."vendor/bin/rector process {$copyDirectoryName}";

        print "\nCompiling...\n";
        (string) $outPut = shell_exec($command);

        print $outPut;
    }
    
}