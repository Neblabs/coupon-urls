<?php

namespace CouponURLs\App\Domain\Coupons;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\Original\Domain\Entities;

Class Coupons extends Entities
{
    protected Cart $cart;

    public function withCart(Cart $cart) : self
    {
        $this->cart = $cart;

        return $this;
    }
    
    protected function getDomainClass() : string
    {
        return Coupon::class;
    }

    public function onlyValid() : self
    {
        return new static($this->entities->getThoseThat(canBeApplied: null));
    }

    public function applyValidTo(Cart $cart) : void
    {
        (object) $readyToBeAdded = $this->onlyValid()->asCollection();

        $readyToBeAdded->forEvery($cart->add(...));
    }
}