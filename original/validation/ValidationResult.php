<?php

namespace CouponURLs\Original\Validation;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use Exception;

Abstract Class ValidationResult
{
    protected $defaultException;
    protected $exception;

    abstract public function isFailing() : bool;
    abstract public function orWhenBoolean(bool $isValid) : ValidationResult;
    abstract public function orWhenValidator(Validator $validator) : ValidationResult;
    abstract public function andWhenBoolean(bool $isValid) : ValidationResult;
    abstract public function andWhenValidator(Validator $validator) : ValidationResult;

    public function __construct(Exception $exception = null)
    {
        $this->defaultException = new ValidationException('Validation Failed!');
        $this->exception = $exception ?? $this->defaultException;
    }

    public function orWhen(bool|Validator $booleanOrValidator) : ValidationResult
    {
        if (is_bool($booleanOrValidator)) {
            return $this->orWhenBoolean($booleanOrValidator);
        }

        return $this->orWhenValidator($booleanOrValidator);
    }

    public function andWhen(bool|Validator $booleanOrValidator) : ValidationResult
    {
        if (is_bool($booleanOrValidator)) {
            return $this->andWhenBoolean($booleanOrValidator);
        }

        return $this->andWhenValidator($booleanOrValidator);
    }

    public function withException(Exception $exception) : ValidationResult
    {
        $this->exception = $exception;

        return $this;
    }

    public function getException() : Exception
    {
        return $this->exception;
    }

    public function setExceptionWhenNoCustomExceptionHasBeenSet(Exception $exception) : ValidationResult
    {
        if ($this->hasDefaultException()) {
            return $this->withException($exception);
        }

        return $this;
    }

    protected function hasDefaultException() : bool
    {
        return $this->defaultException === $this->exception;   
    }
    
}