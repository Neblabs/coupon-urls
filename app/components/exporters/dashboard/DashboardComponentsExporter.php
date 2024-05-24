<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Exporters\Dashboard\DashboardExporterComposite;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;

class DashboardComponentsExporter extends DashboardExporterComposite
{
    public function key(): string
    {
        return 'components';
    } 
}