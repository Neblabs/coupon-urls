<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;

class DependencyContainersFactory implements CreatableContainers
{
    public function __construct(
        protected Collection $dependencyTypes,
        protected ContainerFactory $dependencyContainerFactory
    ) {}
    
    public function create() : Collection
    {
        return $this->dependencyTypes->map($this->dependencyContainerFactory->create(...));
    }
}