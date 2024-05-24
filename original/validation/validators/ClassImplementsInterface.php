<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;
use ReflectionClass;

Class ClassImplementsInterface extends Validator
{
    protected ReflectionClass $implementationReflection;

    public function __construct(
        protected string $interface,
        protected string $implementation
    ) {
        $this->implementationReflection = new ReflectionClass($implementation);
    }
    
    public function execute() : ValidationResult
    {
        return $this->passWhen(
            $this->implementationReflection->implementsInterface($this->interface)
        );
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}