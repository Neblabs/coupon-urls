<?php

namespace CouponURLs\Original\Core\Services;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Construction\Dependency\ProductionDependenciesContainerFactory;
use CouponURLs\Original\Core\Abilities\Service;
use CouponURLs\Original\Core\Abilities\ServicesContainer;
use CouponURLs\Original\Dependency\DependenciesContainer;

class DependenciesService implements Service
{
    protected ?DependenciesContainer $dependenciesContainer;

    public function __construct(
        protected ProductionDependenciesContainerFactory $dependenciesContainerFactory,
        protected GettableCollection $dependencyTypes
    ) {}
    
    public function id(): string
    {
        return 'dependencies';
    } 

    public function container() : ?DependenciesContainer
    {
        return $this->dependenciesContainer;
    }

    public function start(ServicesContainer $servicesContainer): void
    {
        $this->dependenciesContainer = $this->dependenciesContainerFactory->create(
            dependencyTypes: $this->dependencyTypes
        );
    } 

    public function stop(ServicesContainer $servicesContainer): void
    {
        $this->dependenciesContainer = null;
    } 
}