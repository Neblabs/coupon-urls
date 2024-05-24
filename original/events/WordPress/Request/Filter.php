<?php

namespace CouponURLs\Original\Events\Wordpress\Request;

use CouponURLs\Original\Events\Wordpress;

Class Filter extends Hook
{
    public function type(): string
    {
        return Wordpress\Filter::class;
    }
}