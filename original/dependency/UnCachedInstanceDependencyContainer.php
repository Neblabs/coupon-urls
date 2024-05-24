<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\StaticType;

class UnCachedInstanceDependencyContainer extends DependencyContainer
{
    public function __construct(
        protected Dependency&StaticType $dependency,
    ) {}
    
    public function get(string $type): object
    {
        return $this->dependency->create();
    } 
}