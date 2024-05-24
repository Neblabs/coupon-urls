<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class DahsboardURLsExporter implements DashboardExportable
{
    public function key(): string
    {
        return 'urls';
    } 

    public function export(): array
    {
        (object) $homepageUrlParts = _(parse_url(get_home_url()));
        return a(
            homepage: get_home_url(),
            homepageNoProtocol: i("{$homepageUrlParts->get('host')}/{$homepageUrlParts->get('path')}")->replace('//', '/')->trim()->trimRight('/')
        );
    } 
}