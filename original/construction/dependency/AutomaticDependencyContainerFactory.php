<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Dependency\AutomaticDependencyContainer;

use function CouponURLs\Original\Utilities\Collection\_;

class AutomaticDependencyContainerFactory implements CreatableContainers
{
    public function __construct(
        protected DynamicTypeFactory $dynamicTypeFactory
    ) {}
    
    public function create(): Collection
    {
        return _(
            new AutomaticDependencyContainer(
                new DependentFactory(
                    $this->dynamicTypeFactory,
                    new KnownContextFactory
                )
            )
        );
    }  
}