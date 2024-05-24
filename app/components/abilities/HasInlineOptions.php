<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types;

interface HasInlineOptions
{
    public function options() : Collection /*<string, Types>*/; 
}