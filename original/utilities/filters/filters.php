<?php

namespace CouponURLs\Original\Utilities\Filters;

function isInstanceOf(string $type) : callable {
    return fn(mixed $item) => $item instanceof $type;
}