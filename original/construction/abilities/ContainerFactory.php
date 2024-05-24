<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;

interface ContainerFactory
{
    public function create(string|Dependency $dependency) : Container;
}