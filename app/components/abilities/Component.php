<?php

namespace CouponURLs\App\Components\Abilities;

interface Component extends Identifiable
{
    public function entity() : string; 
}