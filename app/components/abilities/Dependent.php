<?php

namespace CouponURLs\App\Components\Abilities;

interface Dependent
{
    public function dependsOn() : string; 
}