<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Deployment\Script;

Class ComposerClassMapReloaderScript extends Script
{
    public function run()
    {
        (string) $copyDirectoryName = $this->data->get('copyDirectoryName');
        (string) $command = "composer dump-autoload -d {$copyDirectoryName}"; // --no-plugins --no-cache --choptimize

        print "\nRunning command: {$command}\n";
        (string) $outPut = shell_exec($command);

        print $outPut;

        print "\nRemoving composer.json:\n";
        var_dump(unlink("{$copyDirectoryName}/composer.json"));
    }
    
}