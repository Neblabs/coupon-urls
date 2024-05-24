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

class CouponToBeAddedNotificationMessageComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier(): string
    {
        return 'CouponToBeAddedNotificationMessage';    
    } 

    public function name()/*: \Stringable*/ 
    {
        return __("Add Custom Message When Coupon hasn't been added yet");
    } 

    public function descriptions() : Collection
    {
        return _(
            __("This message will be shown when the coupon wasn't added to the cart because it didn't meet the cart requirements"),
//            __("For example, if the coupon requires the cart to have a minimum total and the current cart doesn't meet this requirement"),
//            __("This is likely to happen if a new user to your site clicked on this CouponURL and has an empty cart."),
  //          __("This plugin will add the coupon to an internal 'queue' and will apply it automatically once the requirements are met."),
            __("You can use this action to tell the user that they need to add a product or they need a minimum spend."),
        );
    } 

    public function options() : Collection
    {
        return _(
            message: TYPES::STRING()->withDefault(
                __('You have a special offer available! It will be applied when your cart meets the requirements.')
            )->meta(a(
                field: a(
                    width: 'full'
                )
            ))
        );
    }
}
