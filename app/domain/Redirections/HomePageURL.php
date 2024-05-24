<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;

class HomePageURL implements URL
{
    public function get(): string
    {
        return get_home_url();
    } 
}