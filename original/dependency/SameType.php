<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\DynamicType;

class SameType implements DynamicType
{
    public function __construct(
        protected string $type
    ) {}
    
    public function type(): string
    {
        return $this->type;
    } 

    public function defaultType() : string
    {
        return $this->type;
    } 
}