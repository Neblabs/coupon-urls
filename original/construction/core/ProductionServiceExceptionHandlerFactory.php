<?php

namespace CouponURLs\Original\Construction\Core;

use CouponURLs\Original\Construction\Abilities\HandleableServiceExceptionFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Core\Abilities\HandleableServiceException;
use CouponURLs\Original\Core\Exceptions\Handlers\SilentServiceExceptionHandler;
use CouponURLs\Original\Environment\Abilities\Environment;

class ProductionServiceExceptionHandlerFactory implements 
    OverloadableFactory, 
    HandleableServiceExceptionFactory
{
    /** @param Environment $value */
    public function canCreate(mixed $value): bool
    {
        return true;        
    } 

    public function create() : HandleableServiceException
    {
        return new SilentServiceExceptionHandler;
    }
}