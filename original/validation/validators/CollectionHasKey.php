<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\{Validator};
use Exception;

Class CollectionHasKey extends Validator
{
    public function __construct(protected Collection $collection, protected string $key) {}
    
    public function execute() : ValidationResult
    {
        return $this->passWhen($this->collection->hasKey($this->key));
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}