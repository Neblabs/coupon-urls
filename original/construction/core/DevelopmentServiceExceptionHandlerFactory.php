<?php

namespace CouponURLs\Original\Construction\Core;

use CouponURLs\Original\Construction\Abilities\HandleableServiceExceptionFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Core\Abilities\HandleableServiceException;
use CouponURLs\Original\Core\Exceptions\Handlers\UnhandledServiceExceptionHandler;
use CouponURLs\Original\Environment\Abilities\Environment;

class DevelopmentServiceExceptionHandlerFactory implements 
    OverloadableFactory,
    HandleableServiceExceptionFactory
{
    /** @param Environment $value */
    public function canCreate(mixed $value): bool
    {
        return $value->isDevelopment() || $value->isTesting() || (defined('WP_DEBUG') && WP_DEBUG);
    } 

    public function create(): HandleableServiceException
    {
        return new UnhandledServiceExceptionHandler;       
    } 
}