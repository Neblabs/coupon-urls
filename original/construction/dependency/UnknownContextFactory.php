<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use ReflectionParameter;
use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Dependency\UnknownContext;

class UnknownContextFactory implements ContextFactory, OverloadableFactory
{
    // this is the default factory so it should ALWAYS CREATE!
    public function canCreate(mixed $value): bool
    {
        return true;    
    } 

    /** @param ReflectionParameter $value */
    public function create(mixed $value): Context
    {
        return new UnknownContext;
    } 
}