<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Construction\Dependency\DependencyContainerFactory;
use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Dependent;
use CouponURLs\Original\Dependency\DependentDependencyContainer;

class DependentDependencyContainerFactory implements 
    ContainerFactory, 
    OverloadableFactory
{
    public function __construct(
        protected DependencyInspectorFactory $dependencyInspectorFactory,
        protected DependencyContainerFactory $dependencyContainerFactory,
    ) {}

    /** @var Dependency */
    public function canCreate(mixed $value): bool
    {
        (object) $dependencyInspector = $this->dependencyInspectorFactory->create($value::class);

        return $dependencyInspector->isDependent();
    } 

    /** @var Dependent */
    public function create(string|Dependency $dependency): Container
    {
        return new DependentDependencyContainer(
            $dependency,
            $this->dependencyContainerFactory
        );
    } 

}