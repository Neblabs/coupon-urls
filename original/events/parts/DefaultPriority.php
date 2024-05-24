<?php

namespace CouponURLs\Original\Events\Parts;

Trait DefaultPriority
{
    public function priority() : int
    {
        return 10;   
    }
}