<?php

namespace CouponURLs\Original\Utilities\Callables;

use CouponURLs\Original\Language\CallableBuilder;

function call(object $object) : CallableBuilder
{
    return new CallableBuilder($object);
}
