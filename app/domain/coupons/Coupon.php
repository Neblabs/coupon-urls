<?php

namespace CouponURLs\App\Domain\Coupons;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Domain\Entity;
use WC_Coupon;
use WC_Discounts;

use function CouponURLs\Original\Utilities\Text\i;

Class Coupon extends Entity
{
    public function __construct(
        protected WC_Coupon $classic,
        protected ?WC_Discounts $discounts = null
    ) {}
 
    // not empty '', is valid and does not exist in cart    
    public function canBeApplied() : bool
    {
        #might seem weird but is_coupon_valid() returns a WP_error on false
        return $this->discounts->is_coupon_valid($this->classic) === true ?: false;
    }

    public function code() : StringManager
    {
        return i($this->classic->get_code(context: 'edit'));
    }

    public function id() : int
    {
        return $this->classic->get_id();
    }
}