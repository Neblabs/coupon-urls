<?php

namespace CouponURLs\Original\Utilities;

use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

/*******************************************************************************
 *
 *      Validation
 * 
 *******************************************************************************/
/**
 * @throws \Exception
 */
function validate(Validator $validator) : void {
    $validator->validate();
}

/**
 * @throws \Exception
 */
function validateThat(bool $isTrue) : void {
    validate(new ValidWhen($isTrue));
}


