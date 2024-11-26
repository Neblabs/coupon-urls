<?php

namespace CouponURLs\Original\Collections\Mapper;

use AllowDynamicProperties;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\ArrayGetter;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types\AnyType;
use CouponURLs\Original\Collections\Mapper\Types\BooleanType;
use CouponURLs\Original\Collections\Mapper\Types\CollectionType;
use CouponURLs\Original\Collections\Mapper\Types\FloatType;
use CouponURLs\Original\Collections\Mapper\Types\IntegerType;
use CouponURLs\Original\Collections\Mapper\Types\StringType;
use JsonSerializable;
use ReturnTypeWillChange;

#[AllowDynamicProperties]
Abstract Class Types implements JsonSerializable
{
    const STRING = 100000;
    const INTEGER = 200000;
    const FLOAT = 500000;
    const BOOLEAN = 300000;
    const COLLECTION = 400000;
    const ANY = 999999;

    protected $type;
    protected $defaultValue;
    protected $allowedValues;
    protected $anyValueIsAllowed = true;
    protected $sanitizationCallable;
    protected $allowEmptyValue = false;

    protected $meta = [
        '_allowed' => [],
        '_default' => null
    ];

    abstract public function hasDefaultValue();
    abstract public function getTypeAsString() : string;
    abstract protected function setType();
    abstract protected function concretePickValue($newValue);
    abstract protected function isCorrectType($value);

    public static function isString($value)
    {
        return is_string($value) || ($value instanceof StringManager);
    }
    
    public static function STRING()
    {
        return new StringType(static::STRING);
    }

    public static function INTEGER()
    {
        return new IntegerType(static::INTEGER);
    }

    public static function FLOAT()
    {
        return new FloatType(static::FLOAT);
    }

    public static function BOOLEAN()
    {
        return new BooleanType(static::BOOLEAN);
    }

    public static function COLLECTION()
    {
        return new CollectionType(static::COLLECTION);
    }

    public static function ANY()
    {
        return new AnyType(static::ANY);
    }

    public static function returnValueCallable()
    {
        return function($value){return $value;};   
    }
    
    protected function __construct()
    {
        $this->type = $this->setType();   
        $this->allowedValues = new Collection([]);
    }

    public function getType()
    {
        return $this->type;
    }

    public function is($type)
    {
        return $this->getType() === $type;
    }

    public function withDefault($value)
    {
        $this->defaultValue = $this->castToExpectedType($value);

        return $this;   
    }    

    /**
     * Works alongisde withDefault(), this tells types to not pick a default value if 
     * the value passed was the correct type but empty
     */
    public function allowEmptyValue($allowEmptyValue)
    {
        $this->allowEmptyValue = $allowEmptyValue;   

        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;   
    }

    public function allowed(/*Array|Collection*/ $values)
    {
        (array) $values = ArrayGetter::getArrayOrThrowExceptionFrom($values);
        
        $this->allowedValues = new Collection($values);
        $this->anyValueIsAllowed = false;
        return $this;   
    }    

    public function anyValueIsAllowed()
    {
        return $this->anyValueIsAllowed;   
    }

    public function meta(array $metaData)
    {
        $this->meta = $metaData;
        
        return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function sanitize(callable $sanitizationCallable)
    {
        $this->sanitizationCallable = $sanitizationCallable;
    }

    public function escape(callable $escapeCallable)
    {
        $this->escapeCallable = $escapeCallable;
    }
            
    public function hasDefinedEscapeFunction()
    {
        return is_callable($this->escapeCallable);   
    }

    public function hasDefinedSanitizeFunction()
    {
        return is_callable($this->sanitizationCallable);   
    }

    public function getEscapeFunction()
    {
        return $this->escapeCallable;   
    }

    public function getSanitizationFunction()
    {
        return $this->sanitizationCallable;   
    }
    

    public function getAllowedValues()
    {
        return $this->allowedValues;   
    }

    public function getFallbackAllowedValue()
    {
        if ($this->getDefaultValue() !== null) {
            return $this->getDefaultValue();
        }

        return $this->getAllowedValues()->first();
    }

    public function pickValue($newValue)
    {
        if ($this->hasDefaultvalue()) {
            return $this->concretePickValue($newValue);
        }

        return $newValue;
    }

    protected function valueIsScalar($value)
    {
        return (is_string($value) || is_numeric($value) || is_bool($value));   
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize() : mixed
    {
        return [
            'meta' => array_merge($this->meta, [
                '_dataType' => $this->getTypeAsString(),
                '_allowed' => $this->allowedValues,
                '_default' => $this->defaultValue
            ])
        ];
    }
    
    protected function throwExceptionIfTypeIsInvalid($type)
    {
        switch ($type) {
            case static::STRING:
            case static::INTEGER:
            case static::BOOLEAN:
                 // ok
                break;
            
            default:
                throw new \Exception("Invalid type {$type}");
                break;
        }
    }     

    public static function castToExpectedType($value, $beforeResotringToNull = null)
    {
        throw new \Exception("cannot call abstract method castToExpectedType");
    }
}