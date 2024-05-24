<?php

namespace CouponURLs\Original\Events;

use CouponURLs\Original\Events\Wordpress\EventHandler;

interface SubscriberRequiresEventHandler
{
    public function setEventHandler(EventHandler $eventHandler);
}