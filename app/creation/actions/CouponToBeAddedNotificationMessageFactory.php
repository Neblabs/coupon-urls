<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Messages\CouponToBeAddedNotificationMessage;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;

class CouponToBeAddedNotificationMessageFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    public function __construct(
        protected CouponsToBeAdded $couponsToBeAdded
    ) {}
    
    public function create(Coupon $coupon, MappedObject $options): CouponToBeAddedNotificationMessage
    {
        return new CouponToBeAddedNotificationMessage(
            message: $options->message,
            couponsToBeAdded: $this->couponsToBeAdded,
            coupon: $coupon
        );
    } 
}