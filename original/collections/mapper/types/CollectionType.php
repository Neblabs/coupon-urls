<?php

namespace CouponURLs\Original\Collections\Mapper\Types;

use CouponURLs\Original\Collections\Abilities\ArrayRepresentation;
use CouponURLs\Original\Collections\ArrayGetter;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types;

Class CollectionType extends Types
{
    protected $ignorableValues = [];
    protected $separator = null;

    public function __construct() {
        parent::__construct();

        $this->withDefault([]);
    }

    public function getTypeAsString() : string
    {
        return 'collection';
    }   

    protected function setType()
    {
        return static::COLLECTION;
    }

    public function isCorrectType($value)
    {
        return is_array($value);
    }

    public static function castToExpectedType($value, $beforeResotringToNull = null)
    {
        if (is_string($value)) {
            return [];
        }
        return (array) $value;
    }

    public function hasDefaultValue()
    {
        return $this->isCorrectType($this->defaultValue);
    }

    // what to explode() the string with, example: "\n" or ","
    public function separatedBy($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * If it has a default value, fixed allowed values and the passed values are all invalid,
     * then the defaults will be used. 
     *
     * Setting this to true will prevent that and will allow this object to use an empty array instead.
     */
    public function dontUseDefaultIfContainsOnly(array $ignorableValues)
    {
        $this->ignorableValues = $ignorableValues;

        return $this;
    }

    public function concretePickValue($newValue)
    {
        if (is_string($newValue) && !empty($newValue)) {
            $newValue = Collection::createFromString($newValue, $this->separator)->filter()->asArray();
        }

        if (($newValue === [] && !$this->allowEmptyValue) || (is_object($newValue)) || (!is_array($newValue))) {
            return $this->getDefaultValue();
        }

        return $newValue;
    }

    public function getCorrectValues(/*Collection|Array*/$values)
    {
        $values = is_string($values)? Collection::createFromString($values) : static::castToExpectedType($values);
        (object) $valuesCollection = new Collection(ArrayGetter::getArrayOrThrowExceptionFrom($values));
        (object) $filteredValues = $this->filterAllowedValues($valuesCollection);
        (boolean) $itAllowsEmptyValuesButAllPassedValuesWerentAllowed = $this->allowEmptyValue && 
                                                                        $filteredValues->haveNone() && 
                                                                        $valuesCollection->haveAny() && 
                                                                        !$valuesCollection->containAll($this->ignorableValues);

        if ($this->hasDefaultValue() && (($filteredValues->haveNone() && !$this->allowEmptyValue) || $itAllowsEmptyValuesButAllPassedValuesWerentAllowed)) {
            return $this->getFallbackAllowedValue();
        }

        return $filteredValues->asArray();
    }

    protected function filterAllowedValues(Collection $values)
    {
        return $values->filter(function($value){
            return $this->getAllowedValues()->contain($value);
        });
    }
    
}