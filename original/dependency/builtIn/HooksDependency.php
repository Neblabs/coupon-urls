<?php

namespace CouponURLs\Original\Dependency\BuiltIn;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Construction\Events\HookFactory;
use CouponURLs\Original\Construction\Events\HooksFactory;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Events\Wordpress\Framework\RegisteredSubscribers;
use CouponURLs\Original\Events\Wordpress\Hooks;
use CouponURLs\Original\Dependency\WillAlwaysMatch;

class HooksDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected RegisteredSubscribers $registeredSubscribers,
        protected SubscriberFactory $subscriberFactory,
        protected HookFactory $hookFactory
    ) {}
    
    static public function type(): string
    {
        return Hooks::class;        
    } 

    public function create(): object
    {
        (object) $hooksFactory = new HooksFactory(
            hookFactory: $this->hookFactory,
            subscriberFactory: $this->subscriberFactory
        );

        return $hooksFactory->createFromGroupedSubscriberTypes(
            $this->registeredSubscribers->get()
        );
    } 
}