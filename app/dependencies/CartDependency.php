<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;

class CartDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    static public function type(): string
    {
        return Cart::class;   
    } 

    public function create(): Cart
    {
        return new Cart(wc()->cart);
    } 
}