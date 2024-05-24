<?php

namespace CouponURLs\App\Creation\Validators;

use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\DuckInterfaceIsImplemented;
use CouponURLs\Original\Validation\Validators\PassingValidator;

class SubscriberValidatorFactory
{
    public function __construct(
        private string $environment
    ) {}

    public function create(Subscriber $subscriber) : Validator
    {
        return match($this->environment) {
            'production' =>  new PassingValidator,
            default => new DuckInterfaceIsImplemented(
                interface: Subscriber::class,
                implementation: $subscriber::class
            )
        };
    }
}