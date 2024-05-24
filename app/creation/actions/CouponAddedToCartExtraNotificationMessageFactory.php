<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Messages\CouponAddedToCartExtraNotificationMessage;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;

class CouponAddedToCartExtraNotificationMessageFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    public function __construct(
        protected Cart $cart
    ) {}
    
    public function create(Coupon $coupon, MappedObject $options): CouponAddedToCartExtraNotificationMessage
    {
        return new CouponAddedToCartExtraNotificationMessage(
            message: $options->message,
            cart: $this->cart,
            coupon: $coupon
        );
    } 
}