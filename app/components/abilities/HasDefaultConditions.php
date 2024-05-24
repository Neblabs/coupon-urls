<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Characters\StringManager;

interface HasDefaultConditions
{
    public function defaultConditionsMap() : StringManager; 
}