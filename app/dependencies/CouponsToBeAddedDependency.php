<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Creation\Coupons\CouponsFactory;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;

class CouponsToBeAddedDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected CouponsFactory $couponsFactory,
        protected Cart $cart
    ) {}
    
    static public function type(): string
    {
        return CouponsToBeAdded::class;   
    } 

    public function create(): object
    {
        return new CouponsToBeAdded(
            session: wc()->session, 
            couponsFactory: $this->couponsFactory,
        );
    } 
}