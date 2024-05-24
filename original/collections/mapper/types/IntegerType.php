<?php

namespace CouponURLs\Original\Collections\Mapper\Types;

use CouponURLs\Original\Collections\Mapper\Types;

Class IntegerType extends Types
{
    protected $minimum;

    public function getTypeAsString() : string
    {
        return 'number';
    }  

    protected function setType()
    {
        return static::INTEGER;
    }

    public function minimum($number)
    {
        $this->minimum = max((integer) $number, 1);

        return $this;   
    }

    public function hasMinimum()
    {
        return $this->minimum > 0;
    }
    
    public function getMinimum()
    {
        return (integer) $this->minimum;   
    }

    public function getOrDefaultToMinimum($value)
    {
        if ($this->hasMinimum()) {
            if ($this->getMinimum() > $value) {
                return $this->getMinimum();
            }
        }

        return $value;
    }
    
    public function isCorrectType($value)
    {
        return is_numeric($value);
    }

    public static function castToExpectedType($value, $beforeResotringToNull = null)
    {
        return is_numeric($value)? (integer) $value : null;
    }

    public function hasDefaultValue()
    {
        return is_integer($this->defaultValue);
    }

    public function concretePickValue($newValue)
    {
        if (!$this->isCorrectType($newValue)) {
            return $this->getDefaultValue();
        }

        return (integer) $newValue;
    }
}