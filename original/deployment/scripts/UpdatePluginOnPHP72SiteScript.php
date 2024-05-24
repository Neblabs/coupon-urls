<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Deployment\Script;
use CouponURLs\Original\Environment\Env;

Class UpdatePluginOnPHP72SiteScript extends Script
{
    public function run()
    {

        (string) $copyDirectoryName = $this->data->get('copyDirectoryName');

        print "\nUpdating PHP72 plugin...\n";

        //print  shell_exec("rm -rf /Applications/MAMP/htdocs/php72/wp-content/plugins/automated-emails");

        print shell_exec("cp -R {$copyDirectoryName} /Applications/MAMP/htdocs/php72/wp-content/plugins/automated-emails");
    }
    
}