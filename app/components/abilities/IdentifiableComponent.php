<?php

namespace CouponURLs\App\Components\Abilities;

interface IdentifiableComponent
{
    public function component() : Identifiable|HasDefaultConditions; 
}