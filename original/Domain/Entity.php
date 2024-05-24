<?php

namespace CouponURLs\Original\Domain;

use CouponURLs\Original\Validation\Abilities\Validatable;
use CouponURLs\Original\Validation\Validator;

Abstract Class Entity implements Validatable
{
    public function validate(Validator $validator)
    {
        $validator->validate();
    }
}