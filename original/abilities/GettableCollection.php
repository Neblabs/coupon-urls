<?php

namespace CouponURLs\Original\Abilities;

use CouponURLs\Original\Collections\Collection;

interface GettableCollection
{
    public function get() : Collection; 
}