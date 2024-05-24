<?php

namespace CouponURLs\Original\Dependency\BuiltIn;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Error\Abilities\GlobalErrorHandler;
use CouponURLs\Original\Error\IgnitionErrorHandler;
use CouponURLs\Original\Dependency\Abilities\Context;

class ErrorHandlerDependency implements Cached, StaticType, Dependency
{
    static public function type(): string
    {
        return GlobalErrorHandler::class;   
    } 

    public function canBeCreated(Context $context): bool
    {
        return true;        
    } 

    public function create(): object
    {
        return new IgnitionErrorHandler;       
    } 
}