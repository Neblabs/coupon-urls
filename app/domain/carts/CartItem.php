<?php

namespace CouponURLs\App\Domain\Carts;

use CouponURLs\App\Domain\Products\Product;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class CartItem
{
    protected Cart $cart;
    public readonly string $key;

    public function __construct(
        public readonly Product $product,
        protected $quantity = 1,
        public readonly Collection $extraData = new Collection
    ) {}

    public function key(Cart $cart) : string
    {
        return $cart->generateItemKey($this);
    }

    public function quantity() : int
    {
        return $this->quantity;
    }

    public function export() : Collection
    {
        return _(
            product_id: $this->product->is('variation')? $this->product->classic->get_parent_id() : $this->product->classic->get_id(),
            quantity: $this->quantity,
            variation_id: $this->product->is('variation')? $this->product->classic->get_id() : 0,
            variation: $this->product->is('variation')? $this->product->classic->get_variation_attributes($with_prefix = false) : [],
            cart_item_data: $this->extraData->asArray()
        );
    }
}