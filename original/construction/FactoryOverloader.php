<?php

namespace CouponURLs\Original\Construction;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use Exception;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;

class FactoryOverloader
{
    public function __construct(
        protected Collection $overloadableFactories
    ) {
        validate(new ItemsAreOnlyInstancesOf(
            allowedTypes: _(OverloadableFactory::class),
            items: $overloadableFactories, 
        ));
    }

    public function overload(mixed $value) : OverloadableFactory
    {
        return $this->overloadableFactories->find(
            fn(OverloadableFactory $overloadableFactory) => $overloadableFactory->canCreate(
                $value
            )
        ) ?? $this->throwExceptionWhenNotFound();
    }

    protected function throwExceptionWhenNotFound() : void
    {
        throw new Exception("No overloadableFactory found!");
    }
}