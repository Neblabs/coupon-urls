<?php

namespace CouponURLs\Original\Core\Exceptions\Handlers;

use CouponURLs\Original\Core\Abilities\HandleableServiceException;
use Throwable;
use CouponURLs\Original\Core\Abilities\Service;

class SilentServiceExceptionHandler implements HandleableServiceException
{
    public function handle(Throwable $exception, Service $service)
    {
        // keep quite when an exception is thrown, so that 
        // the whole program (website) doesn't crash.
    } 
}