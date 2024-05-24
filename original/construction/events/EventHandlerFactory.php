<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Construction\Event\Exceptions\ExceptionHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventHandler;

Class EventHandlerFactory
{
    public function __construct(
        protected ExceptionHandlerFactory $exceptionHandlerFactory = new ExceptionHandlerFactory
    ) {}

    public function create(Subscriber $subscriber) : Eventhandler
    {
        return new EventHandler(
            $subscriber,
            $this->exceptionHandlerFactory
        );   
    }
}