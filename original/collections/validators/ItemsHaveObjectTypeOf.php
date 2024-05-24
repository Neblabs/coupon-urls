<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Exceptions\InvalidTypeException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;

class ItemsHaveObjectTypeOf extends Validator
{
    protected ?string $invalidType;

    public function __construct(
        protected Collection $items,
        protected Collection $allowedTypes
    ) {}

    public function execute(): ValidationResult
    {
        return $this->failWhen(
            (boolean) $this->invalidType = $this->items->find(
                fn(mixed $item) => !$this->allowedTypes->have(
                    fn(string $fullyQualifiedTypeName) => is_a(
                        $item, 
                        $fullyQualifiedTypeName, 
                        allow_string: true
                    )
                )
            )
        );
    } 

    protected function getDefaultException(): Exception
    {
        throw new InvalidTypeException(
            "Type: {$this->invalidType} must implement: {$this->allowedTypes->implode(' | ')}"
        );
    } 
}