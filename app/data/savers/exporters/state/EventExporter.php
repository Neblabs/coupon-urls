<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Data\Finders\Events\EventStructure;
use CouponURLs\App\Domain\Posts\Post;

class EventExporter implements DashboardExportableForCoupon
{
    public function __construct(
        protected EventStructure $eventStructure
    ) {}
    
    public function key(): string
    {
        return 'event';
    } 

    public function export(Post $post): string
    {
        return get_post_meta(
            post_id: $post->id(),
            key: $this->eventStructure->fields()->id()->id()->get(),
            single: true
        );
    } 
}