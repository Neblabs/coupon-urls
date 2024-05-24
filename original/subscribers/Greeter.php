<?php

namespace CouponURLs\Original\Subscribers;

use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

use function CouponURLs\Original\Utilities\Collection\_;

Class Greeter implements Subscriber
{
    use DefaultPriority;

    public function createEventArguments() : EventArguments
    {
        return new EventArguments(_(
            name: 'Rafa'
        ));
    }

    public function validator() : Validator
    {
        return new PassingValidator;
    }

    public function execute(string $name) : void
    {
        //exit("Hello, {$name}!");
    }
} 

