<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Container;

class DependencyTypeToContainerFactory implements ContainerFactory
{
    public function __construct(
        protected DependencyFactory $dependencyFactory,
        protected DependencyContainerFactory $dependencyContainerFactory
    ) {}
    
    /** @var string */
    public function create(string|Dependency $dependency): Container
    {
        return $this->dependencyContainerFactory->create(
            $this->dependencyFactory->create($dependency)
        );
    } 
}