<?php

namespace CouponURLs\App\Presentation\Components\Dashboarddevelopmentscripts;

use CouponURLs\Original\Presentation\Component;

Class DashboardDevelopmentScripts extends Component
{
    protected $file = 'dashboardDevelopmentScriptsView.php';
    public string $dashboardID;  

    public function __construct($dashboardID)
    {
        $this->dashboardID = $dashboardID;   
    }
    
}