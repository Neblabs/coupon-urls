<?php

namespace CouponURLs\App\Domain\Actions\Products;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Carts\CartItem;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;

class AddProduct implements Actionable, RestrictableAction
{
    public function __construct(
        protected CartItem $item,
        protected Coupon $coupon,
        protected Cart $cart,
    ) {}
    
    public function canPerform(): Validator
    {
        return new Validators([
            new ValidWhen(
                $this->cart->quanititiesOf($this->item->product) < $this->item->quantity()
            ),
        ]);
    } 

    public function perform(): void
    {
        (integer) $neededQuantityToMeetMinimumRequired = $this->item->quantity() - $this->cart->quanititiesOf($this->item->product);
        /**
         * Lets create a new instance because if we modify the quantity of the current
         * CartItem instance and for some reason the cart state changes later, 
         * we might have an incorrect quantity. So let's keep the quantities of
         * the original CartItem intact.
         * 
         */
        $this->cart->add(
            new CartItem(
                product: $this->item->product,
                quantity: $neededQuantityToMeetMinimumRequired
            )
        );
    } 
}