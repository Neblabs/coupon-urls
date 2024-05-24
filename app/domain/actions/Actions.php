<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\Original\Domain\Entities;

class Actions extends Entities
{
    protected function getDomainClass(): string
    {
        return Actionable::class;
    } 
}