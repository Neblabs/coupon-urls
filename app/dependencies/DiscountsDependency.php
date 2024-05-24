<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use WC_Discounts;

class DiscountsDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected Cart $cart
    ) {}
    
    static public function type(): string
    {
        return WC_Discounts::class;        
    } 

    public function create(): object
    {
        return new WC_Discounts($this->cart->classic);
    } 
}