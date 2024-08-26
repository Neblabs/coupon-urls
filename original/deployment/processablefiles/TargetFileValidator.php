<?php

namespace CouponURLS\Original\Deployment\Processablefiles;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Validation\Validator;

abstract class TargetFileValidator extends Validator
{
    public function __construct(
        protected StringManager $targetFile
    ) {}
    
    
    protected function getDefaultException() : \Exception
    {
        throw new \Exception('file validation exception');
    }
}