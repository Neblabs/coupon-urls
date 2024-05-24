<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use Exception;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;

class Old_Container
{
    public function __construct(
        protected Collection $dependencies
    ) {
        validate(
            new ItemsAreOnlyInstancesOf(
                items: $dependencies,
                allowedTypes: _(Dependency::class)
            )
        );
    }

    public function inject(string $fullyQualifiedTypeName) : object
    {
        return $this->dependenciesForType($fullyQualifiedTypeName)->first();
    }

    protected function dependenciesForType(string $fullyQualifiedTypeName) : Collection
    {
        return $this->dependencies->get($fullyQualifiedTypeName) 
                ?? 
               throw new Exception(
                    "No registered dependency for type: {$fullyQualifiedTypeName}"
                );
    }
    
}