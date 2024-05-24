<?php

namespace CouponURLs\App\Dashboard;

use CouponURLs\App\Components\Exporters\Dashboard\DashboardExporterComposite;
use CouponURLs\App\Domain\Coupons\Coupon;
use WP_Post;

class DashboardData extends DashboardExporterComposite
{
    public function key(): string
    {
        return 'CouponURLs';
    } 

    public function export(WP_Post $post): array
    {
        // this will trigger the jsonserializable on StringManager and Collection instances
        return json_decode(wp_json_encode(parent::export($post)), flags: JSON_OBJECT_AS_ARRAY); 
    } 
}