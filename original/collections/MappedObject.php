<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Utilities\ObjectSetter;
use CouponURLs\Original\Collections\Abilities\ArrayRepresentation;
use OutOfBoundsException;
use ReflectionObject;
use ReflectionProperty;
use StdClass;

Class MappedObject extends StdClass implements ArrayRepresentation
{
    protected $mapFieldsFoundInSource;
    protected $mapFieldsNotFoundInSource;
    protected $allFieldsFoundInSource;
    protected $dataFound;
    protected $rawDataFound; // the raw data as it was received, in a plain object format (first level only)

    public function __construct(Array $values = [])
    {
        ObjectSetter::setPublicValues(['object' => $this, 'values' => $values]);

        $this->mapFieldsFoundInSource = new Collection([]);   
        $this->mapFieldsNotFoundInSource = new Collection([]);  
        $this->allFieldsFoundInSource = new Collection([]); 
    }

    public function setMappedFieldsFound(MappedObject $mappedObjectOnlyWithFieldsFound)
    {
        $this->dataFound = $mappedObjectOnlyWithFieldsFound;
    }

    public function setRawDataFound(Collection $rawDataFound)
    {
        $this->rawDataFound = $rawDataFound;   
    }
    
    public function asRawArray() : array
    {
        (object) $reflection = new ReflectionObject($this);

        return $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
    }
    

    public function asArray()
    {
        (array) $publicProperties = [];

        foreach($this->asRawArray() as $publicProperty) {

            $value = $this->{$publicProperty->name};
            
            if ($value instanceof MappedObject) {
                $value = $value->asArray();
            }

            $publicProperties[$publicProperty->name] = $value;
        }

        return $publicProperties;
    }

    public function asCollection()
    {
        return new Collection($this->asArray());   
    }    

    public function __get($property)
    {
        return $this->{$property};
    }

    public function __clone()
    {
        (object) $properties = (new Collection(get_object_vars($this)))->getKeys();

        $properties->forEvery(function($property){
            if (is_object($this->{$property})) {
                $this->{$property} = clone $this->{$property};
            }
        });
    }
    
}