<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Exceptions\InvalidTypeException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Exception;

Class ItemsAreOnlyInstancesOf extends Validator
{
    protected mixed $invalidType;

    public function __construct(
        protected Collection $items,
        protected Collection $allowedTypes
    ) {}
    
    public function execute() : ValidationResult
    {
        return $this->failWhen(
            (boolean) $this->invalidType = $this->items->find(
                fn(mixed $item) => !$this->allowedTypes->have(
                    fn(string $fullyQualifiedTypeName) => $item instanceof $fullyQualifiedTypeName
                )
            )
        );
    }

    protected function getDefaultException() : Exception
    {
        throw new InvalidTypeException(
            "Type: {$this->invalidReadableType()} must implement: {$this->allowedTypes->implode(' | ')}"
        );
    }

    protected function invalidReadableType() : string
    {
        return match($nativeType = gettype($this->invalidType)) {
            'object' => $this->invalidType::class,
            default => $nativeType
        };
    }
}