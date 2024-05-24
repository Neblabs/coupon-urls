<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Deployment\Script;

Class ProductionEnvironmentSetter extends Script
{
    public function run()
    {
        (string) $copyDirectoryName = $this->data->get('copyDirectoryName');
        (string) $settingsFile = $copyDirectoryName . '/app/settings/default.php';

        (object) $prefences = require $settingsFile;
        (string) $productionEnvironment = 'production';

        $prefences->environment = $productionEnvironment;

        file_put_contents($settingsFile, "<?php return ".var_export($prefences, true).";");

        print "\nenvironment changed to {$productionEnvironment}\n";
    }
    
}