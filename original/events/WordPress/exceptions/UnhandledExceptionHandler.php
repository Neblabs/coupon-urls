<?php

namespace CouponURLs\Original\Events\Wordpress\Exceptions;

use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use Throwable;

class UnhandledExceptionHandler implements ExceptionHandler
{
    public function handle(Throwable $exception): mixed
    {
        throw $exception;
    } 
}