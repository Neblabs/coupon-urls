<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;

interface Container
{
    public function matches(string $type, Context $context) : bool;
    public function get(string $type) : object;
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void; 
}