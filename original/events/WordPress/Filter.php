<?php

namespace CouponURLs\Original\Events\Wordpress;

Class Filter extends Hook
{
    public function register() : void
    {
        foreach ($this->subscribers as $subscriber) {
            (object) $eventHandler = $this->eventHandlerFactory->create($subscriber);
            
            $this->globalFunctionWraper->add_filter(
                hook_name: $this->name, 
                callback: $eventHandler->handle(...),
                priority: $subscriber->priority(),
                accepted_args: $this->numberOfAcceptedArgumentsForSubscriber($subscriber)
            );
        }        
    }

    public function unregister(): void
    {
        
    } 
}