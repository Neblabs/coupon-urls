<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;

use function CouponURLs\Original\Utilities\Collection\_;

class TextDomainExporter implements DashboardExportable
{
    public function key(): string
    {
        return 'textDomain';
    } 

    public function export(): string
    {
        return Env::textDomain();
    } 
}