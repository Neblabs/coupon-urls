<?php

namespace CouponURLs\Original\Events\Wordpress\Exceptions;

use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions;
use Throwable;

class ManualExceptionHandler implements ExceptionHandler
{
    public function __construct(
        protected ManuallyHandleExceptions $handler
    ) {}

    public function handle(Throwable $exception): mixed
    {
        return $this->handler->onException($exception);    
    } 
}