<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\{Validator};
use Exception;

Class FailingValidator extends Validator
{
    public function execute() : ValidationResult
    {
        return $this->passWhen(false);
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}