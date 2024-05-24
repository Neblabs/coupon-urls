<?php

namespace CouponURLs\App\Domain\URIs;

use CouponURLs\Original\Domain\Entities;

Class URIs extends Entities
{
    protected function getDomainClass() : string
    {
        return URI::class;
    }
}