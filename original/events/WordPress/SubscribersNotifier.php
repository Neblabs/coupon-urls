<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Events\EventHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\Abilities\CustomEvent;
use CouponURLs\Original\Events\Wordpress\EventHandler;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use function CouponURLs\Original\Utilities\Collection\_;

class SubscribersNotifier
{
    public function __construct(
        protected GlobalFunctionWrapper $globalFunctionWrapper = new GlobalFunctionWrapper,
        protected EventsHandler $eventsHandler = new EventsHandler(new EventHandlerFactory)
    ) {}

    public function addSubscriber(Subscriber $subscriber) : void
    {
        $this->eventsHandler->addSubscriber($subscriber);
    }

    public function notify(CustomEvent $event) : void
    {
        $this->eventsHandler->handle($event);

        $this->globalFunctionWrapper->do_action(
            hook_name: $event::class,
            arg: $event
        );
    }
}