<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\WillAlwaysExecute;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;

use function CouponURLs\Original\Utilities\Collection\_;

/**
 * Listens to cart changes and tries to apply those coupons
 */
Class ScheduledCouponsApplier implements Subscriber
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
            allCouponsThatMightBeAdded: $this->couponsToBeAdded->coupons()
        ));
    }

    public function execute(Coupons $allCouponsThatMightBeAdded) : void
    {
        $allCouponsThatMightBeAdded->applyValidTo($this->cart);
    }
} 

