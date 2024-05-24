<?php

namespace CouponURLs\Original\Construction\Data;

use CouponURLs\Original\Collections\Collection;
use WP_Query;

class WP_QueryFactory
{
    public function createWithArguments(Collection $arguments) : WP_Query
    {
        return new WP_Query($arguments->asArray());
    }
}