<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;

trait WillAlwaysMatch 
{
    public function canBeCreated(Context $context) : bool
    {
        return true;
    }  
}