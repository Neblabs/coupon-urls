<?php

namespace CouponURLs\App\Components\Actions\Builtin;

use CouponURLs\App\Components\Abilities\Descriptables;
use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\__;

class AddProductComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier(): string
    {
        return 'AddProduct';    
    } 

    public function name()/*: \Stringable*/ 
    {
        return __('Add Product');
    }

    public function descriptions() : Collection
    {
        return _(
            __("The product will only be added if it isn't in the cart already"),
        );
    }  

    public function options() : Collection
    {
        return _(
            quantity: TYPES::INTEGER()->withDefault(1)->meta(a(
                field: a(
                    labels: a(left: __('Quantity'))
                )
            )),
            id: TYPES::INTEGER()->meta(a(
                name: 'ID'
            ))->meta(a(
                field: a(
                    searchable: a(
                        url: esc_url(admin_url('admin-ajax.php')),
                        data: a(
                            action: 'woocommerce_json_search_products_and_variations',
                            security: esc_html(wp_create_nonce('search-products')),
                            term: '((value))',
                        )
                    )
                )
            )),
        );
    }

}
