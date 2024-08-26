<?php

namespace CouponURLS\Original\Deployment\Processablefiles;

use CouponURLS\Original\Validation\ValidationResult;
use CouponURLS\Original\Validation\Validator;

class PHPFileValidator extends TargetFileValidator
{
    public function execute(): ValidationResult
    {
        return $this->passWhen($this->targetFile->endsWith('.php'));
    } 
}