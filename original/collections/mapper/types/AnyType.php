<?php

namespace CouponURLs\Original\Collections\Mapper\Types;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Mapper\Types;

Class AnyType extends Types
{
    public function getTypeAsString() : string
    {
        return 'mixed';
    }  

    protected function setType()
    {
        return static::ANY;
    }

    public function isCorrectType($value)
    {
        return true;
    }

    public function hasDefaultValue()
    {
        return false;
    }

    public function concretePickValue($newValue)
    {
        return $newValue;
    }
}