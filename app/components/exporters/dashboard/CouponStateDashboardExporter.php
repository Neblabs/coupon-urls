<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Components\Components;
use CouponURLs\Original\Environment\Env;
use WP_Post;

use function CouponURLs\Original\Utilities\Text\i;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class CouponStateDashboardExporter implements DashboardExportableForPost
{
    public function __construct(
    ) {}
    
    public function key(): string
    {
        return 'coupon';
    } 

    public function export(WP_Post $post): array
    {
        return a(
            hasURI: $post
        );
    } 
}