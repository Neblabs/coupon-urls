<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Cache\Cache;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Dependency\Abilities\Context;

class DependentDependencyContainer implements Container
{
    public function __construct(
        protected Dependent $dependent,
        protected ContainerFactory $dependencyContainerFactory,
        protected Cache $storage = new MemoryCache
    ) {}

    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer): void
    {
        $this->dependent->setDependenciesContainer($dependenciesContainer);    
    }   

    public function matches(string $type, Context $context): bool
    {
        return is_a($type, $this->dependent->type(), allow_string: true) 
                && 
               $this->dependencyContainer()->matches($type, $context);
    } 

    public function get(string $type): object
    {
        return $this->dependencyContainer()->get($type);
    } 

    protected function dependencyContainer() : DependencyContainer
    {
        return $this->storage->getIfExists('dependencyContainer')->otherwise(
            fn() => $this->dependencyContainerFactory->create(
                $this->dependent->create()
            )
        );
    }
}