<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;

interface HasRequirements
{
    public function requires() : Collection; 
}