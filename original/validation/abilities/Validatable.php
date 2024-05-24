<?php

namespace CouponURLs\Original\Validation\Abilities;

use CouponURLs\Original\Validation\Validator;

Interface Validatable
{
    public function validate(Validator $validator);
}