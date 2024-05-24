<?php

namespace CouponURLs\App\Components\Actions;

use CouponURLs\Original\Collections\Collection;

interface ActionComponents
{
    public function actions() : Collection; 
}