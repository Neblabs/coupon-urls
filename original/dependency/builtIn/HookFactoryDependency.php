<?php

namespace CouponURLs\Original\Dependency\BuiltIn;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Events\HookFactory;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Abilities\Context;

class HookFactoryDependency implements Cached, StaticType, Dependency
{
    static public function type(): string
    {
        return HookFactory::class;   
    } 

    public function canBeCreated(Context $context): bool
    {
        return true;        
    } 

    public function create(): object
    {
        return new HookFactory;       
    } 
}