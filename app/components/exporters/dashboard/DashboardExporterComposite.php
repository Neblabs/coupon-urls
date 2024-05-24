<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Posts\Post;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use WP_Post;

use function CouponURLs\Original\Utilities\Collection\a;

abstract class DashboardExporterComposite implements DashboardExportableForPost
{
    public function __construct(
        protected Collection $dashboardExporters
    ) {}
    
    public function addExporter(DashboardExportable $dashboardExporter)
    {
        $this->dashboardExporters->push($dashboardExporter);
    }
    
    public function export(WP_Post $post): array
    {
        return $this->dashboardExporters->mapWithKeys(
            fn(DashboardExportable|DashboardExportableForPost $dashboardExporter) => a(
                key: $dashboardExporter->key(),
                value: $dashboardExporter->export($post)
            )
        )->asArray();
    } 
}