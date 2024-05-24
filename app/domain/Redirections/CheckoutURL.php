<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;

class CheckoutURL implements URL
{
    public function get(): string
    {
        return get_permalink(wc_get_page_id('checkout'));
    } 
}