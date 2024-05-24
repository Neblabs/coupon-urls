<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\App\Components\Data\DataTypeComponent;

interface DataTypeable
{
    public function dataType() : DataTypeComponent;
}