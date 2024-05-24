<?php

namespace CouponURLs\App\Domain\Abilities;

use CouponURLs\Original\Validation\Validator;

interface RestrictableAction
{
    public function canPerform() : Validator; 
}