<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;

interface Provider
{
    public function provides() : Collection; 
}