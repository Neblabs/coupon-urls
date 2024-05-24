<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Abilities\DynamicType;

class DynamicTypeFactory
{
    public function __construct(
        protected FactoryOverloader $factoryOverloader
    ) {}

    public function create(string $dependencyType) : DynamicType
    {
        (object) $dynamicTypeFactory = $this->factoryOverloader->overload($dependencyType);

        return $dynamicTypeFactory->create($dependencyType);
    }
}