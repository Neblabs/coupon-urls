<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\App\Components\Components;

interface HasDependents
{
    public function addDependent(Identifiable|Typeable $dependent) : void;
    public function dependents() : Components; 
}