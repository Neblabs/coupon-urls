<?php

namespace CouponURLs\Original\Construction\Event\Exceptions;

use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions;
use CouponURLs\Original\Events\Wordpress\Exceptions\UnhandledExceptionHandler;

class UnhandledExceptionHandlerFactory extends ExceptionHandlerFactory
{
    public function create(Subscriber|ManuallyHandleExceptions $subscriber) : ExceptionHandler
    {
        return new UnhandledExceptionHandler;
    }
}