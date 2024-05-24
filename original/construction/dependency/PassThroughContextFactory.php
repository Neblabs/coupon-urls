<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\Abilities\Context;

class PassThroughContextFactory implements ContextFactory, OverloadableFactory
{
    public function canCreate(mixed $value): bool
    {
        return $value instanceof Context;
    } 

    /** @param Context $value */
    public function create(mixed $value): Context
    {
        return $value;       
    } 
}