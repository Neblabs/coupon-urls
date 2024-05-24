<?php

namespace CouponURLs\Original\Events\Wordpress\Exceptions;

use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use Throwable;

class SilentExceptionHandler implements ExceptionHandler
{
    public function handle(Throwable $exception)
    {
        /**
         * We've captured the Exception!
         *
         * Let's keep the program running, nothing ever happened here. 
         */
    } 
}