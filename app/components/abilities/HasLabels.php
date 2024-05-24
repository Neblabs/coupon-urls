<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;

interface HasLabels
{
    public function labels() : Collection; 
}