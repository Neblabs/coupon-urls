<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\Exceptions\InvalidTypeException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;

Class ValidType extends Validator
{
    private $value;
    private $fullyQualifiedType;

    public function __construct(/**/ $value, string $fullyQualifiedType)
    {
        $this->value = $value;
        $this->fullyQualifiedType = $fullyQualifiedType;
    }
    
    public function execute() : ValidationResult
    {
        return $this->passWhen($this->value instanceof $this->fullyQualifiedType);
    }

    protected function getDefaultException() : Exception
    {
        return new InvalidTypeException(
            "Object must be an instance of {$this->fullyQualifiedType}, instance of ".get_class($this->value)." given."
        );   
    }
    
}