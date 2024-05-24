<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Events\Wordpress\Action;
use CouponURLs\Original\Events\Wordpress\Filter;
use CouponURLs\Original\Events\Wordpress\Hook;
use CouponURLs\Original\Events\Wordpress\Request;

Class HookFactory 
{
    public function createFromRequest(Request\Hook $hookRequest) : Hook
    {
        (string) $name = $hookRequest->name();

        return match($hookRequest->type()) {
            Action::class => new Action($name),
            Filter::class => new Filter($name)
        };
    }
}