<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\DependencyContainerFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\CachedInstanceDependencyContainer;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Container;

class CachedInstanceDependencyContainerFactory implements 
    ContainerFactory, 
    OverloadableFactory
{
    /** @var Dependency */
    public function canCreate(mixed $value): bool
    {
        return $value instanceof Dependency && $value instanceof Cached;
    } 

    /** @var Dependency */
    public function create(string|Dependency $dependency): Container
    {
        return new CachedInstanceDependencyContainer($dependency);
    } 
}