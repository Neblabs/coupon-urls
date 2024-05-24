<?php

namespace CouponURLs\Original\Collections\Mapper\Types;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Mapper\Types;

Class BooleanType extends Types
{
    public function getTypeAsString() : string
    {
        return 'boolean';
    }  

    protected function setType()
    {
        return static::BOOLEAN;
    }

    public function isCorrectType($value)
    {
        return is_bool($value);
    }

    public static function castToExpectedType($value, $beforeResotringToNull = null)
    {
        if (static::isBooleanString($value) && in_array((string) $value, ['true', 'false'])) {
            return ((string) $value) === 'true'? true : false;
        } elseif (is_bool($value)) {
            return $value;
        } elseif ($beforeResotringToNull !== null) {
            return $beforeResotringToNull;
        } else {
            return null;
        }
    }

    public static function exportValue($value)
    {
        return $value? 'true' : 'false';   
    }

    public function hasDefaultValue()
    {
        return is_bool($this->defaultValue);
    }

    public function concretePickValue($newValue)
    {
        if (!$this->isBoolean($newValue)) {
            return $this->getDefaultValue();
        }

        return $newValue;
    }

    protected function isBoolean($newValue)
    {
        return is_bool($newValue) || static::isBooleanString($newValue);
    } 

    protected static function isBooleanString($value)
    {
        return (is_string($value) || ($value instanceof StringManager)) && in_array((string) $value, ['true', 'false']);
    }
}