<?php

namespace CouponURLs\Original\Dependency\Framework;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Abilities\UnCached;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsHaveObjectTypeOf;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Exceptions\InvalidDependencyException;
use CouponURLs\Original\Validation\Validators;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;

class ValidDependencyTypes implements GettableCollection
{
    protected Collection $dependencyTypes;

    public function __construct(
        protected GettableCollection $dependencyTypesGetter
    ) 
    {
        $this->dependencyTypes = $this->dependencyTypesGetter->get();

        validate(
            new Validators([
                (new ItemsHaveObjectTypeOf(
                    items: $this->dependencyTypes, 
                    allowedTypes: _(
                        Dependency::class
                    )
                ))->withException(
                    new InvalidDependencyException("One or more of your dependencies do not implement ".Dependency::class)
                ),
                (new ItemsHaveObjectTypeOf(
                    items: $this->dependencyTypes, 
                    allowedTypes: _(
                        StaticType::class
                    )
                ))->withException(
                    new InvalidDependencyException("One or more of your dependencies do not implement ".StaticType::class.". Direct Dependency classes may only implement StaticType.")
                ),
                //
                (new ItemsHaveObjectTypeOf(
                    items: $this->dependencyTypes, 
                    allowedTypes: _(
                        UnCached::class,
                        Cached::class
                    )
                ))->withException(new InvalidDependencyException("Each Dependency must implement either ".UnCached::class." or ".Cached::class))
            ])
        );
    }
    
    public function get(): Collection
    {
        return $this->dependencyTypes;
    } 
}