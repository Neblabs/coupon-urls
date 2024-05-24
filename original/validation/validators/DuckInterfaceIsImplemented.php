<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ClassImplementsInterface;
use Exception;
use ReflectionClass;

Class DuckInterfaceIsImplemented extends Validator
{
    public function __construct(
        protected string $interface,
        protected string $implementation
    ) {}
    
    public function execute() : ValidationResult
    {
        return $this->passWhen(
            new ClassImplementsInterface($this->interface, $this->implementation)
        )->andWhen(
            new DuckMethodsAreImplementedCorrectly($this->interface, $this->implementation)
        );
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}