<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\HasDependents;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Typeable;
use CouponURLs\Original\Collections\SingleItem;

class ComponentWithDependents implements HasDependents
{
    public function __construct(
        protected Components $dependents = new Components()
    ) {}
    
    public function dependents(): Components
    {
        return $this->dependents;
    } 

    public function addDependent(Identifiable|Typeable $dependent): void
    {
        $this->dependents->add(new SingleItem($dependent));
    } 
}