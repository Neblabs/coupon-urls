<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Dependency\Dependent;

class DependentFactory 
{
    public function __construct(
        protected DynamicTypeFactory $dynamicTypeFactory,
        protected ContextFactory $contextFactory
    ) {}
    
    public function create(string $type) : Dependent
    {
        return new Dependent(
            $this->dynamicTypeFactory->create($type),
            $this->contextFactory
        );
    }
}
