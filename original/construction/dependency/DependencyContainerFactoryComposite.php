<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\DependencyContainerFactory;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\DependencyContainer;

class DependencyContainerFactoryComposite implements ContainerFactory
{
    public function __construct(
        protected FactoryOverloader $factoryOverloader
    ) {}

    public function create(string|Dependency $dependency) : Container
    {
        /** @var DependencyContainerFactory */
        (object) $dependencyContainerFactory = $this->factoryOverloader->overload($dependency);

        return $dependencyContainerFactory->create($dependency);
    }
}