<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Characters\StringManager;

interface HasConditionsTemplate
{
    public function template() : StringManager; 
}