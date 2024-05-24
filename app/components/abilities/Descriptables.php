<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;
use Stringable;

interface Descriptables
{
    public function descriptions() : Collection;
}