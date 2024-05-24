<?php

namespace CouponURLs\Original\Construction\Event\Exceptions;

use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\Abilities\AutomaticallyHandleExceptions;
use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions;
use CouponURLs\Original\Events\Wordpress\Exceptions\ManualExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Exceptions\SilentExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Exceptions\UnhandledExceptionHandler;

class ExceptionHandlerFactory
{
    public function create(Subscriber|ManuallyHandleExceptions $subscriber) : ExceptionHandler
    {
        return match(true) {
            $subscriber instanceof AutomaticallyHandleExceptions => new SilentExceptionHandler,
            $subscriber instanceof ManuallyHandleExceptions => new ManualExceptionHandler(
                $subscriber
            ),
            default => new UnhandledExceptionHandler
        };
    }
}