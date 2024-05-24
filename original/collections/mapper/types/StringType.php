<?php

namespace CouponURLs\Original\Collections\Mapper\Types;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Mapper\Types;

Class StringType extends Types
{
    public function getTypeAsString() : string
    {
        return 'string';
    }  

    public static function stringsOnly()
    {
        return function ($value) {
            return Types::isString($value);
        };
    }
    
    protected function setType()
    {
        return static::STRING;
    }

    public function isCorrectType($value)
    {
        return Types::isString($value);
    }

    public static function castToExpectedType($value, $beforeResotringToNull = null)
    {
        if ($value instanceof StringManager) {
            return $value;
        }
        
        (string) $value = is_string($value)? $value : '';

        return new StringManager($value);
    }

    public function hasDefaultValue()
    {
        if (is_string($this->defaultValue)) {
            return $this->defaultValue !== '';
        }

        return ($this->defaultValue instanceof StringManager) && 
               (!$this->defaultValue->isEmpty());  
    }

    public function concretePickValue($newValue)
    {
        if (($newValue === '') || !$this->isCorrectType($newValue)) {
            return $this->getDefaultValue();
        }

        return $newValue;
    }
}