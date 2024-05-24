<?php

namespace CouponURLs\Original\Core\Exceptions\Handlers;

use CouponURLs\Original\Core\Abilities\HandleableServiceException;
use Throwable;
use CouponURLs\Original\Core\Abilities\Service;

class UnhandledServiceExceptionHandler implements HandleableServiceException
{
    public function handle(Throwable $exception, Service $service)
    {
        throw $exception;
    } 
}