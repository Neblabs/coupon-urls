<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\DynamicType;

class DynamicDependent implements DynamicType
{
    public function type(): string
    {
        return $this->type;
    } 
}