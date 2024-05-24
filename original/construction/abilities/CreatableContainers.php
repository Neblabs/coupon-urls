<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Collections\Collection;

interface CreatableContainers
{
    public function create() : Collection; 
}