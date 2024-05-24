<?php

namespace CouponURLs\App\Build\Scripts;

use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Deployment\Script;

Class WebpackProductionBuilderScript extends Script
{
    public function run()
    {
        system('cd /Applications/MAMP/htdocs/coupons-plus/wp-content/plugins/coupons-plus/app/scripts/dashboard && npm run build | gnomon');
   }
    
}