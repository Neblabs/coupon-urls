<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Components;

abstract class ComponentsExporter implements DashboardExportable
{
    public function __construct(
        protected Components $components
    ) {}
    
}