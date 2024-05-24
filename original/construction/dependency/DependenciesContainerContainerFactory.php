<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Dependency\DependenciesContainerContainer;

use function CouponURLs\Original\Utilities\Collection\_;

class DependenciesContainerContainerFactory implements CreatableContainers
{
    public function create(): Collection
    {
        return _(
            new DependenciesContainerContainer
        );
    } 
}