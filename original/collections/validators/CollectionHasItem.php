<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Exception;

Class CollectionHasItem extends Validator
{
    public function __construct(
        protected Collection $items,
        protected mixed $item,
        protected bool $shouldHaveIt = true
    ) {}
    
    public function execute() : ValidationResult
    {
        (boolean) $hasItem = $this->items->have(fn(mixed $item) => $item === $this->item);

        return $this->passWhen(
            $this->shouldHaveIt? $hasItem : !$hasItem
        );
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}