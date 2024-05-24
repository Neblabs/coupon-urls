<?php

namespace CouponURLs\App\Domain\Carts;

use CouponURLs\Original\Domain\Entities;

Class Carts extends Entities
{
    protected function getDomainClass() : string
    {
        return Cart::class;
    }
}