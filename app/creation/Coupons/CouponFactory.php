<?php

namespace CouponURLs\App\Creation\Coupons;

use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Characters\StringManager;
use WC_Coupon;
use WC_Discounts;

class CouponFactory
{
    public function __construct(
        protected WC_Discounts $discounts
    ) {}
    
    public function createFromCodeOrID(string|StringManager|int $codeOrId) : Coupon
    {
        return new Coupon(
            classic: new WC_Coupon($codeOrId), 
            discounts: $this->discounts
        );
    }
}