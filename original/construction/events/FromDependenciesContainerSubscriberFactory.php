<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Dependency\DependenciesContainer;
use CouponURLs\Original\Events\OptionalRegisterableSubscriber;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Validation\Validator;

class FromDependenciesContainerSubscriberFactory implements SubscriberFactory
{
    public function __construct(
        protected DependenciesContainer $dependenciesContainer
    ) {}

    public function canBeCreated(string $SubscriberType): bool
    {
        if (is_a($SubscriberType, OptionalRegisterableSubscriber::class, allow_string: true)) {
            /** @var Validator */
            (object) $validator = $SubscriberType::canBeRegistered();

            return $validator->isValid();
        }

        return true;
    }   

    public function create(string $subscriberType): Subscriber
    {
        return $this->dependenciesContainer->get($subscriberType);
    } 
}