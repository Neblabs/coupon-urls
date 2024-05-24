<?php

namespace CouponURLs\App\Domain\Actions\CouponAdders;

use CouponURLs\App\Domain\Actions\OverloadableActionsDecorator;

Class AddCoupon extends OverloadableActionsDecorator
{
    /**
     * DONT FORGET THAT WE NEED TO REMOVE FROM THE COUPONS TO BE ADDED 
     * AFTER THE COUPON HAS SUCCESSFULLY BEEN APPLIED!
     */
}