<?php

namespace CouponURLs\App\Data\Savers\Abilities;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\Validator;

interface Saveable
{
    public function canBeSaved(Collection $data) : Validator;
    public function save(Collection $data); 
}