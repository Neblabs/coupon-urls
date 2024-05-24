<?php

namespace CouponURLs\App\Creation\Coupons\Couponurls\Abilities;

use CouponURLs\App\Domain\Coupons\Coupon;

interface CreatableFromCouponUrl
{
    public function createFromCoupon(Coupon $coupon) : object;
}