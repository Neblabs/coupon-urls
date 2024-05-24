<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Components\Actions\Builtin\AddProductComponent;
use CouponURLs\App\Components\Actions\Builtin\RedirectionComponent;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use WP_Post;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class PreloadedDataExporter implements DashboardExportableForPost
{
    public function __construct(
        protected AddProductComponent $addProductComponent,
        protected RedirectionComponent $redirectionComponent
    ) {}
    
    public function key(): string
    {
        return 'preloadedItems';
    } 

    public function export(WP_Post $post): array
    {
        $addProductData = get_post_meta(
            $post->ID, 
            Env::getWithPrefix("action_{$this->addProductComponent->identifier()}"),
            single: true
        );
        $redirectProductData = get_post_meta(
            $post->ID, 
            Env::getWithPrefix("action_{$this->redirectionComponent->identifier()}"),
            single: true
        );

        $productId = i($addProductData? $addProductData : '{}')->import()?->id ?? 0;

        $redriectionLabel = [];

        if ($redirectProductData) {
            (object) $options = i($redirectProductData)->import();
            if ($options?->type === 'postType') {
                $redriectionLabel = a(
                    value: $options->value,
                    label: get_post((integer) $options->value)?->post_title
                );
            }
        }
        return [
            $this->addProductComponent->identifier() => $productId? [a(value: $productId, label: wc_get_product($productId)?->get_name('edit'))] : [],
            $this->redirectionComponent->identifier() => [$redriectionLabel] ?: []
        ];
    } 
}