<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;

class NotEmpty extends Validator
{
    public function __construct(
        protected mixed $value
    ) {}
    
    public function execute(): ValidationResult
    {
        return $this->passWhen(!empty($this->value));
    } 

    protected function getDefaultException(): Exception
    {
        return new Exception("Value: {$this->value} must not be empty.");
    }  
}