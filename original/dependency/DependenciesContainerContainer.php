<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;

class DependenciesContainerContainer implements Container
{
    protected DependenciesContainer $dependenciesContainer;

    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer): void
    {
        $this->dependenciesContainer = $dependenciesContainer;    
    } 

    public function matches(string $type, Context $context): bool
    {
        return $type === DependenciesContainer::class;        
    } 

    public function get(string $type): object
    {
        return $this->dependenciesContainer;              
    } 
}