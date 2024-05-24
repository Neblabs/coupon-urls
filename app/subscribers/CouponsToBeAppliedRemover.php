<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\WillAlwaysExecute;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use function CouponURLs\Original\Utilities\Collection\_;

/**
 * Removes the coupons to be applied that have already been applied and 
 * are now in the cart
 */
Class CouponsToBeAppliedRemover implements Subscriber
{
    use DefaultPriority;
    use WillAlwaysExecute;

    public function __construct(
        protected CouponsToBeAdded $couponsToBeAdded,
        protected Cart $cart
    ) {}
    
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(_(
            allCouponsToBeAdded: $this->couponsToBeAdded->coupons()
        ));
    }

    public function execute(Coupons $allCouponsToBeAdded) : void
    {
        (object) $couponsToBeRemoved = $allCouponsToBeAdded->asCollection()->filter(
            $this->cart->has(...)
        );

        $couponsToBeRemoved->forEvery($this->couponsToBeAdded->remove(...));
    }
} 

