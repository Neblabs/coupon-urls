<?php

namespace CouponURLs\Original\Dependency;

class UnknownDependentContainer implements DependentContainer
{
    public function __construct(
        protected Dependent $dependent
    ) {}
    
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer): void
    {
        $this->dependent->setDependenciesContainer($dependenciesContainer);
    } 

    public function matches(string $type): bool
    {
        return true;
    } 

    public function get(): Dependency
    {
        return $this->dependent;
    } 
}