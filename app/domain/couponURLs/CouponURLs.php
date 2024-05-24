<?php

namespace CouponURLs\App\Domain\CouponURLs;

use CouponURLs\Original\Domain\Entities;

Class CouponURLs extends Entities
{
    protected function getDomainClass() : string
    {
        return CouponURL::class;
    }
}