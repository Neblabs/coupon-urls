<?php

namespace CouponURLs\Original\Subscribers;

use CouponURLs\Original\Core\Abilities\ServicesContainer;
use CouponURLs\Original\Core\Application;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

use function CouponURLs\Original\Utilities\Collection\_;

Class ServicesRestarter implements Subscriber
{
    use DefaultPriority, EmptyCustomArguments;

    public function __construct(
        protected Application $application
    ) {}
    
    public function validator() : Validator
    {
        (boolean) $itsTheSecondTimeInitHasBeenCalled = did_action('init') > 1;

        return new ValidWhen($itsTheSecondTimeInitHasBeenCalled);
    }

    public function execute() : void
    {
        $this->application->stop();

        $this->application->start();
    }
} 

