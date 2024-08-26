<?php

namespace CouponURLS\Original\Deployment\Processablefiles;

use CouponURLS\Original\Validation\ValidationResult;
use CouponURLS\Original\Validation\Validator;

class NOTVendorFileValidator extends TargetFileValidator
{
    public function execute(): ValidationResult
    {
        return $this->passWhen(!$this->targetFile->matchesRegEx('/coupon-urls[\w0-9-_]*\/vendor/'));
    } 
}