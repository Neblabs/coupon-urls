<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Dependency\DependencyInspector;

class DependencyInspectorFactory
{
    public function create(string $dependencyClassName) : DependencyInspector
    {
        return new DependencyInspector($dependencyClassName);
    }
}