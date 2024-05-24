<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Exceptions\UncreatableDependencyContainerException;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
use Exception;

use function CouponURLs\Original\Utilities\Collection\_;

class DependencyContainerFactory implements ContainerFactory
{
    public function __construct(
        protected DependencyInspectorFactory $dependencyInspectorFactory
    ) {}
    
    /** @var Dependency */
    public function create(string|Dependency $dependency): Container
    {
        try {
            return $this->createContainer($dependency);
        } catch (Exception) {
            $this->throwException($dependency);
        }
    } 

    /** @var Dependency */
    protected function createContainer(Dependency $dependency) : Container
    {
        (object) $dependencyContainerFactoryComposite = new DependencyContainerFactoryComposite(
            new FactoryOverloader(_(
                new DependentDependencyContainerFactory(
                    $this->dependencyInspectorFactory,
                    $this
                ),
                new CachedInstanceDependencyContainerFactory,
                new UnCachedInstanceDependencyContainerFactory
            ))
        );

        return $dependencyContainerFactoryComposite->create($dependency);   
    }
 
    protected function throwException(mixed $dependency) : void
    {
        throw new UncreatableDependencyContainerException(
            "Cannot create Container from dependency: ".(is_object($dependency)? $dependency::class : $dependency).
            "\nMake sure the Dependency instance implements Cached or Uncached."
        );
    }
}