<?php

namespace CouponURLs\App\Domain\Abilities;

interface Actionable
{
    public function perform(): void; 
}