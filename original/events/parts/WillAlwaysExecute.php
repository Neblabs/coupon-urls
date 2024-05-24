<?php

namespace CouponURLs\Original\Events\Parts;

use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

trait WillAlwaysExecute
{
    public function validator() : Validator
    {
        return new PassingValidator;
    }
}