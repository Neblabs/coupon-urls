<?php

namespace CouponURLs\App\Presentation\Components;

use AllowDynamicProperties;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Presentation\Component;

use function CouponURLs\Original\Utilities\Collection\_;
#[AllowDynamicProperties]
class CouponsToBeAppliedTableComponent extends Component
{
    protected $file = 'couponstobeappliedtable.php';

    public function __construct(CouponsToBeAdded $couponsToBeAdded)
    {
        $this->data = _(
            couponsToBeAdded: $couponsToBeAdded
        );
    }
}