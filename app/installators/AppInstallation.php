<?php

namespace CouponURLs\App\Installators;

use CouponURLs\App\Data\Settings\Settings;
use CouponURLs\Original\Data\Drivers\WordPressDatabaseDriver;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Installation\Installation;
use CouponURLs\Original\Installation\Installator;

Class AppInstallation extends Installation
{
    protected $applicationDatabase;

    public function __construct()
    {
        (string) $ApplicationDatabase = Env::settings()->schema->applicationDatabase;

        $this->applicationDatabase = new $ApplicationDatabase(new WordPressDatabaseDriver);   

        parent::__construct();
    }

    public function install()
    {
        // Nothing yet...
    }

    public function activate()
    {
        $this->applicationDatabase->install();
    }

    public function deactivate()
    {
        // Nothing yet...
    }
}