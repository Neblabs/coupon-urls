<?php

namespace CouponURLs\App\Creation\Coupons;

use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\Original\Collections\Collection;

class CouponsFactory
{
    public function __construct(
        protected CouponFactory $couponFactory
    ) {}
    
    public function createFromCodes(Collection $couponCodes) : Coupons
    {
        return new Coupons($couponCodes->map($this->couponFactory->createFromCodeOrID(...)));
    }
}