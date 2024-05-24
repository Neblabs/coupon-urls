<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Closure;
use Exception;

Class ValidWhen extends Validator
{
    public function __construct(
        protected bool|Closure $value
    ) {}
    
    public function execute() : ValidationResult
    {
        (boolean) $value = is_callable($this->value)? (($this->value)()) : $this->value;

        return $this->passWhen($value === true);
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}