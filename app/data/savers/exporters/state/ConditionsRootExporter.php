<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Data\Finders\ConditionsRoot\ConditionsRootStructure;
use CouponURLs\App\Domain\Posts\Post;

use function CouponURLs\Original\Utilities\Collection\_;

class ConditionsRootExporter implements DashboardExportableForCoupon
{
    public function __construct(
        protected ConditionsRootStructure $conditionsRootStructure
    ) {}
    
    public function key(): string
    {
        return 'conditionsRoot';
    } 

    public function export(Post $post): string
    {
        (string) $conditionsRootSource = get_post_meta(
            post_id: $post->id(),
            key: $this->conditionsRootStructure->fields()->id()->id()->get(),
            single: true
        );

        if (is_object(json_decode($conditionsRootSource))) {
            return $conditionsRootSource;
        }

        return _(
            type: 'none',
            subjectConditions: [
            ]
        )->asJson();
    } 
}