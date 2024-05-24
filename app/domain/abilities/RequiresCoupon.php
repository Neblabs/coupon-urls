<?php

namespace CouponURLs\App\Domain\Abilities;

use CouponURLs\App\Domain\Coupons\Coupon;

interface RequiresCoupon
{
    public function setCoupon(Coupon $coupon) : void; 
}