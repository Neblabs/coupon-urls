<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Construction\Dependency\ContainersFactory;
use CouponURLs\Original\Dependency\Abilities\Context;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class DependenciesContainer implements ContainableDependencies
{
    protected Collection $containers;
    protected Collection $currentDependencyStack;

    public function __construct(
        protected ContainersFactory $containersFactory,
        protected ContextFactory $contextFactory
    ) {
        $this->containers = $containersFactory->create();
        $this->containers->forEvery(
            fn(Container $container) => $container->setDependenciesContainer($this)
        );
        $this->currentDependencyStack = _();
    }
    
    public function get(string $type, ?Context $context = null): object
    {
        $this->addToStack($type, $context);

        (object) $container = $this->resolve(
            type: $type, 
            context: $this->contextFactory->create($context)
        );

        (object) $resolvedDependency = $container->get($type);

        $this->removeLastStackItem();

        return $resolvedDependency;
    }

    public function currentDependencyStack() : Collection
    {
        return clone $this->currentDependencyStack;
    }
    
    protected function resolve(string $type, Context $context) : Container
    {
        return $this->containers->find(
            fn(Container $container) => $container->matches(
                type: $type,
                context: $context
            )
        );
    }

    protected function addToStack(string $type, Context $context = null) : void
    {
        // this format (type and context is kind of looking like an class/object of itself, just look at the resolve() method above (and inside Dependent), there's a clear pattern)
        $this->currentDependencyStack->push(a(
            type: $type,
            context: $context
        ));
    }

    protected function removeLastStackItem() : void
    {
        $this->currentDependencyStack->removelast();
    }
}