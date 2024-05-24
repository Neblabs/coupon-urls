<?php

namespace CouponURLs\Original\Exceptions;

use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use Throwable;

class UnhandledExceptionHandler implements ExceptionHandler
{
    public function handle(Throwable $exception)
    {
        throw $exception;
    } 
}