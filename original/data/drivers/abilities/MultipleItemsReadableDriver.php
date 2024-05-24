<?php

namespace CouponURLs\Original\Data\Drivers\Abilities;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Query\Parameters;

interface MultipleItemsReadableDriver {
    public function findMany(Parameters $parameters) : Collection;
    public function count(Parameters $parameters) : int;
}