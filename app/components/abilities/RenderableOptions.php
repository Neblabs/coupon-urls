<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;

interface RenderableOptions
{
    public function render() : Collection; 
}