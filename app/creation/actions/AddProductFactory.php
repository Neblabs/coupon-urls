<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Products\AddProduct;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Carts\CartItem;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Products\Product;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;

class AddProductFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    public function __construct(
        protected Cart $cart,
    ) {}
    
    public function create(Coupon $coupon, MappedObject $options): AddProduct
    {
        return new AddProduct(
            item: new CartItem(
                product: new Product(wc_get_product($options->id)),
                quantity: $options->quantity
            ),
            coupon: $coupon,
            cart: $this->cart
        );
    } 
}