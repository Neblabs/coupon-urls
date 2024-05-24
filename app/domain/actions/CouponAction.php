<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\RequiresCoupon;
use CouponURLs\App\Domain\Coupons\Coupon;

abstract class CouponAction implements RequiresCoupon
{
    protected Coupon $coupon;

    public function setCoupon(Coupon $coupon): void
    {
        $this->coupon = $coupon;
    } 
}