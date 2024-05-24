<?php

namespace CouponURLs\Original\Dependency\Abilities;

/**
 * Not implemented yet, but an idea of an interface to be used to decide if the context
 * for the requested type is correct.
 *
 * This way you can have two or more Dependency classes for the same type
 * but for different contexts, like one Dependency should be used on a
 * Subscriber and another Dependency when the same type is requested by
 * a Controller
 */
interface Context
{
    public function classIs(string $fullyQualifiedClassName) : bool;
    public function methodIs(string $name) : bool;
    public function nameIs(string $variableName) : bool;
    //public function isConstructor() : bool;
    //public function isConstructorOfClass(string $fullyQualifiedClassName) : bool;
}

/**
 * Example usage in a Dependencyd
 * 
 

class MyDependency extends SameInstanceDependency
{
    protected function canBeUsedIn(Context $context) : bool
    {
        return $context->isConstructorOfClass(MyClass::class);
    }
}
*/