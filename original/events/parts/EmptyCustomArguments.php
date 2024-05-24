<?php

namespace CouponURLs\Original\Events\Parts;

use CouponURLs\Original\Events\Wordpress\EventArguments;

use function CouponURLs\Original\Utilities\Collection\_;

Trait EmptyCustomArguments
{
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(_(
            //
        ));
    }
}