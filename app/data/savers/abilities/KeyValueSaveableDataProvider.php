<?php

namespace CouponURLs\App\Data\Savers\Abilities;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\Validator;

interface KeyValueSaveableDataProvider
{
    public function inputKey() : string; 
    public function outputKey() : string;

    public function canBeSaved(StringManager $dataToSave) : Validator; 
    public function dataToSave(StringManager $dataToSave) : Collection|string|int|float;
}