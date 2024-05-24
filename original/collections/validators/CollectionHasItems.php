<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Exception;

Class CollectionHasItems extends Validator
{
    public function __construct(
        protected Collection $collection,
        protected Collection $itemsToCheck,
        protected string $permission,
        protected string $quantifier
    ) {}
    
    public function execute() : ValidationResult
    {
        /*bool*/ $collectionHasThem = match($this->quantifier) {
            'any' => $this->collection->containAny($this->itemsToCheck),
            'all' => $this->collection->containAll($this->itemsToCheck),
        };
        
        $matches = match($this->permission) {
            'allowed' => $collectionHasThem,
            'forbidden' => !$collectionHasThem,
            default => false
        };
        
        return $this->passWhen($matches);
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}