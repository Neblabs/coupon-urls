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

class CouponAddedToCartExtraNotificationMessageComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier(): string
    {
        return 'CouponAddedToCartExtraNotificationMessage';    
    } 

    public function name()/*: \Stringable*/ 
    {
        return __("Add an Extra Message After Applying to the Cart");
    } 

    public function descriptions() : Collection
    {
        return _(
            __("This extra message will be shown after the coupon has been successfully added to the cart."),
        );
    } 

    public function options() : Collection
    {
        return _(
            message: TYPES::STRING()->withDefault(
                __('Congratulations! Your special offer has been applied!')
            )->meta(a(
                field: a(
                    width: 'full'
                )
            ))
        );
    }
}
