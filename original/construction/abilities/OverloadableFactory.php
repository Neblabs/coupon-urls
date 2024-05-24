<?php

namespace CouponURLs\Original\Construction\Abilities;

interface OverloadableFactory
{
    public function canCreate(mixed $value) : bool; 
}