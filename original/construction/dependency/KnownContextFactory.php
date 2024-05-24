<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Dependency\KnownContext;

use function CouponURLs\Original\Utilities\Text\i;

use ReflectionParameter;

class KnownContextFactory implements ContextFactory, OverloadableFactory
{
    /** @param ReflectionParameter $value */
    public function canCreate(mixed $value): bool
    {
        return  $value instanceof ReflectionParameter
                    &&
                $value->hasType() 
                    && 
                class_exists($value->getType());
    } 

    /** @param ReflectionParameter $value */
    public function create(mixed $value): Context
    {
        return new KnownContext(
            fullyQualifiedTypeName: i($value->getDeclaringClass()->getName()),
            methodName: i($value->getDeclaringFunction()->getShortName()),
            variableName: i($value->getName())
        );
    } 
}