<?php

namespace CouponURLs\Original\Validation;

use CouponURLs\Original\Validation\FailingValidationResult;
use CouponURLs\Original\Validation\PassingValidationResult;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use Exception;

Abstract Class Validator
{
    protected ?Exception $customException = null;

    abstract public function execute() : ValidationResult;
    /**
     * For the most part, Validators have been designed to validate a single value at a time.
     * For those cases, use this method to set the Exception so that each method only does one thing.
     * (the static::execute() method should be responsible for the validation logic and the 
     * static::getDefaultException() method should be responsible for setting the error).
     *
     * You can, however, send different Exceptions by manually sending different ValidationResult objects
     * in the static::execute() method, and manually setting the Exceptions on each object.
     *
     * ***** IMPORTANT *****
     *     When a ValidationResult has been set a custom Exception, this default exception will not be used. 
     */ 
    abstract protected function getDefaultException() : Exception;

    /**
     * @throws \Exception
     */
    public function validate() : void
    {
        (object) $validationResult = $this->execute();

        if ($validationResult->isFailing()) {
            (object) $exception = $validationResult->setExceptionWhenNoCustomExceptionHasBeenSet(
                                                        $this->getException()
                                                    )
                                                   ->getException();

            throw new $exception;
        }
    }
    
    /**
     * Use when you want a boolean value.
     * using static::validate() is generally preferred because you can 
     * give context as to why the validation failed.
     */
    public function isValid() : bool
    {
        try {
            $this->validate();          
        } catch (Exception $exception) {
            return false;
        }   

        return true;
    }

    public function withException(Exception $exception) : Validator
    {
        $this->customException = $exception;

        return $this;
    }

    public function getException() : Exception
    {
        if ($this->customException) {
            return $this->customException;
        }

        return $this->getDefaultException();
    }

    protected function passed() : PassingValidationResult
    {
        return new PassingValidationResult;   
    }

    protected function failed() : FailingValidationResult
    {
        return new FailingValidationResult;   
    }
    
    protected function passWhen(bool|Validator $isTrueOrValidatorHasPassed) : ValidationResult
    {
        if (is_bool($isTrueOrValidatorHasPassed)) {
            return $this->passWhenBooleanIsTrue($isTrueOrValidatorHasPassed);
        }

        return $this->passWhenValidatorIsValid($isTrueOrValidatorHasPassed);
    }

    protected function passWhenBooleanIsTrue(bool $isTrue) : ValidationResult
    {
        if ($isTrue) {
            return new PassingValidationResult;
        }

        return new FailingValidationResult;
    }
    
    protected function passWhenValidatorIsValid(Validator $validator) : ValidationResult
    {
        if ($validator->isValid()) {
            return new PassingValidationResult;
        }

        return new FailingValidationResult($validator->getDefaultException());
    }
    
    protected function failWhen(bool $isTrue) : ValidationResult
    {
        if ($isTrue) {
            return new FailingValidationResult;
        }

        return new PassingValidationResult;
    }
}