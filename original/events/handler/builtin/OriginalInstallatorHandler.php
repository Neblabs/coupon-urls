<?php

namespace CouponURLs\Original\Events\Handler\BuiltIn;

use CouponURLs\App\Installators\AppInstallation;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Handler\EventHandler;

Class OriginalInstallatorHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        (object) $installator = new AppInstallation;
    }
}