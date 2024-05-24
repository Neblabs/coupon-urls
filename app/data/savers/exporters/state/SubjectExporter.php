<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Domain\Posts\Post;

class SubjectExporter implements DashboardExportableForCoupon
{
    public function key(): string
    {
        return 'subject';
    } 

    public function export(Post $post): string
    {
        return $post->titleRaw();
    } 
}