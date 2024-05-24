<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Data\Finders\Recipients\RecipientStructure;
use CouponURLs\App\Domain\Posts\Post;

use function CouponURLs\Original\Utilities\Collection\_;

class RecipientsExporter implements DashboardExportableForCoupon
{
    public function __construct(
        protected RecipientStructure $recipientStructure
    ) {}
    
    public function key(): string
    {
        return 'recipients';
    } 

    public function export(Post $post): array
    {
        return _(get_post_meta(
            post_id: $post->id(),
            key: $this->recipientStructure->fields()->id()->id()->get(),
            single: false
        ))->map(fn(string $baseRecipinet) => json_decode($baseRecipinet)->email)->asArray();
    } 
}