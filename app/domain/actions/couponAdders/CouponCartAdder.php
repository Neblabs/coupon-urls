<?php

namespace CouponURLs\App\Domain\Actions\CouponAdders;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Actions\CouponAction;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use WC_Cart;

class CouponCartAdder implements Actionable, RestrictableAction
{
    public function __construct(
        protected Coupon $coupon,
        protected Cart $cart
    ) {}
    
    public function canPerform(): Validator
    {
        return new Validators([
            new ValidWhen(!$this->cart->isEmpty()),
            new ValidWhen($this->coupon->canBeApplied())
        ]);
    } 

    public function perform(): void
    {
        $this->cart->add($this->coupon);
    } 
}