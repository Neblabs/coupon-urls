<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\MappedObject;

interface ActionFromCouponAndMappedObjectFactory
{
    public function create(Coupon $coupon, MappedObject $options) : Actionable;
}