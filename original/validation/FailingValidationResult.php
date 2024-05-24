<?php

namespace CouponURLs\Original\Validation;

use CouponURLs\Original\Validation\PassingValidationResult;
use CouponURLs\Original\Validation\Validators\PassingValidator;

Class FailingValidationResult extends ValidationResult
{
    public function orWhenBoolean(bool $isValid): ValidationResult
    {
        if ($isValid) {
            return new PassingValidationResult;
        }

        return new self;
    }

    // we don't care, we're passing so we don't have to validate the other results
    public function orWhenValidator(Validator $validator): ValidationResult
    {
        if ($validator->isValid()) {
            return new PassingValidationResult;
        }

        return (new self($validator->getException()));
    } 

    // will always fail because it already failed and we need all to pass    
    public function andWhenBoolean(bool $isValid): self
    {
        return $this;
    }

    // will always fail because it already failed and we need all to pass    
    public function andWhenValidator(Validator $validator): self
    {
        return $this->withException($validator->getException());
    } 
    
    public function isFailing() : bool
    {
        return true;   
    }
}