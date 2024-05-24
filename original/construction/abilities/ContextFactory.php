<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Dependency\Abilities\Context;

use ReflectionParameter;

interface ContextFactory
{
    public function create(mixed $value) : Context;
}