<?php

namespace CouponURLs\Original\Validation;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\PassingValidationResult;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidType;
use Exception;

Class Validators extends Validator
{
    private $vaildators;

    public function __construct(Iterable $validators)       
    {
        $this->validateOnlyHasValidator($validators);

        $this->validators = $validators;
    }
    
    public function execute() : ValidationResult
    {
        foreach ($this->validators as $validator) {
            $validator->validate();
        }

        return new PassingValidationResult;
    }

    protected function validateOnlyHasValidator(Iterable $validators)
    {
        foreach ($validators as $validator) {
            (object) $isValidatorType = new ValidType($validator, Validator::class);

            $isValidatorType->validate();
        }
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}