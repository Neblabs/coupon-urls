<?php

namespace CouponURLs\Original\Dependency;

use ReflectionClass;

class DependencyInspector
{
    public function __construct(
        protected string $dependency
    ) {}
    
    public function isDependency() : bool
    {
        return is_a(
            $this->dependency,
            class: Dependency::class,
            allow_string: true
        );
    }

    public function hasDependencies() : bool
    {
        (boolean) $itsNotAClass = !class_exists($this->dependency);

        if ($itsNotAClass) {
            return false;
        }
        
        (object) $reflector = new ReflectionClass($this->dependency);
        (object) $constructor = $reflector->getConstructor();
        (boolean) $hasNoConstructor = !$constructor;

        if ($hasNoConstructor) {
            return false;
        }

        return (boolean) $constructor->getParameters();
    }

    public function isDependent() : bool
    {
        return is_a(
            $this->dependency,
            class: Dependent::class,
            allow_string: true
        );;
    }

}