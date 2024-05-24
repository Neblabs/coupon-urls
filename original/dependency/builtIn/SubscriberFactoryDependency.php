<?php

namespace CouponURLs\Original\Dependency\BuiltIn;


use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Construction\Events\FromDependenciesContainerSubscriberFactory;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\DependenciesContainer;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Abilities\Context;

class SubscriberFactoryDependency implements Cached, StaticType, Dependency
{
    public function __construct(
        protected DependenciesContainer $dependenciesContainer
    ) {}
    
    static public function type(): string
    {
        return SubscriberFactory::class;        
    } 

    public function canBeCreated(Context $context): bool
    {
        return true;        
    } 

    public function create(): FromDependenciesContainerSubscriberFactory    
    {
        return new FromDependenciesContainerSubscriberFactory(
            $this->dependenciesContainer
        );
    } 
}