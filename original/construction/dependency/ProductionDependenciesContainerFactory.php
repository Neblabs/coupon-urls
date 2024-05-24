<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\DependenciesContainer;

use function CouponURLs\Original\Utilities\Collection\_;

class ProductionDependenciesContainerFactory
{
    public function create(GettableCollection $dependencyTypes) : DependenciesContainer
    {
        return new DependenciesContainer(
            new ContainersFactory(
                _(
                    $this->dependenciesContainerContainerFactory(),
                    $this->dependencyContainersFactory($dependencyTypes->get()),
                    $this->automaticDependentContainerFactory(),
                    $this->unresolvableDependencyContainerFactory()
                )
            ),
            new OverloadedContextFactory(
                new FactoryOverloader(_(
                    new PassThroughContextFactory,
                    new UnknownContextFactory
                ))
            )
        );
    }

    protected function dependenciesContainerContainerFactory() : CreatableContainers
    {
        return new DependenciesContainerContainerFactory;   
    }
    
    protected function dependencyContainersFactory(Collection $dependencyTypes) : CreatableContainers    
    {
        return new DependencyContainersFactory(
            $dependencyTypes,
            new DependencyTypeToContainerFactory(
                new DependencyFactory(
                    new DependencyInspectorFactory,
                    new DependentFactory(
                        $this->dynamicTypeFactory(),
                        new OverloadedContextFactory(
                            new FactoryOverloader(_(
                                new KnownContextFactory,
                                new UnknownContextFactory
                            ))
                        )
                    )
                ),
                new DependencyContainerFactory(
                    new DependencyInspectorFactory
                )
            )
        );
    }

    protected function automaticDependentContainerFactory() : CreatableContainers
    {
        return new AutomaticDependencyContainerFactory(
            $this->dynamicTypeFactory()
        );
    }

    protected function unresolvableDependencyContainerFactory() : CreatableContainers
    {
        return new UnresolvableDependencyContainerFactory;
    }

    protected function dynamicTypeFactory() : DynamicTypeFactory
    {
        (object) $productionDynamicTypeFactory = new ProductionDynamicTypeFactory;

        return $productionDynamicTypeFactory->create();
    }
    
}