<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\Abilities\DynamicType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\SameType;

class DependentDynamicTypeFactory implements OverloadableFactory
{
    /** @param string $value */
    public function canCreate(mixed $value): bool
    {
        return !is_a($value, Dependency::class, allow_string: true);
    } 

    public function create(string $type) : DynamicType
    {
        return new SameType($type);
    }
}