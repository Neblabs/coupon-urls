<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Events\Wordpress\Hook;
use CouponURLs\Original\Events\Wordpress\Hooks;
use CouponURLs\Original\Events\Wordpress\Request;

class HooksFactory
{
    public function __construct(
        protected HookFactory $hookFactory,
        protected SubscriberFactory $subscriberFactory
    ) {}
    
    public function createFromGroupedSubscriberTypes(Collection $groupedSubscriberTypes) : Hooks
    {
        return new Hooks(
            $groupedSubscriberTypes->map(
                function(Collection $subscribersGroup, string $hookName) {
                    (object) $hook = $this->hookFactory->createFromRequest(
                        new Request\Action(name: $hookName)
                    );

                    $hook->addSubscribers($subscribersGroup->filter(function(string $subscriberType) {
                        return $this->subscriberFactory->canBeCreated($subscriberType);
                    })->map(
                        fn(string $subscriberType) => $this->subscriberFactory->create(
                            $subscriberType
                        )
                    ));

                    return $hook;
                }
            )
        );
    }
}