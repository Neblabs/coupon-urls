<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Events\Wordpress\EventHandler;

use function CouponURLs\Original\Utilities\Collection\_;

Class Action extends Hook
{
    public function register(): void
    {
        foreach ($this->subscribers as $subscriber) {
            (object) $eventHandler = $this->eventHandlerFactory->create($subscriber);
            (object) $handle = $eventHandler->handle(...);

            $this->addHandler($handle, $subscriber->priority());

            $this->globalFunctionWraper->add_action(
                hook_name: $this->name, 
                callback: $handle,
                priority: $subscriber->priority(),
                accepted_args: $this->numberOfAcceptedArgumentsForSubscriber($subscriber)
            );
        }
    }

    public function unregister(): void
    {
        $this->handlers->forEvery(
            fn(array $handlerAndPriority) => $this->globalFunctionWraper->remove_action(
                hook_name: $this->name,
                callback: $handlerAndPriority['handler'],
                priority: $handlerAndPriority['priority']
            )
        );

        $this->handlers = _();
    } 
}