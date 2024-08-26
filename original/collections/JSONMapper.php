<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Mapper\Mappable;
use CouponURLs\Original\Collections\Mapper\Types;
use CouponURLs\Original\Collections\Mapper\Types\BooleanType;
use CouponURLs\Original\Collections\Mapper\Types\CollectionType;
use CouponURLs\Original\Collections\Mapper\Types\StringType as S;
use CouponURLs\Original\Environment\Env;
use StdClass;

Class JSONMapper
{
    protected $mapDefinition = [];

    public $mappedObjectOnlyWithFieldsFound;

    public static function getArrayFromJson($JSONString)
    {
        (string) $json = static::getValidJsonString($JSONString);

        return json_decode($json, $asArray = true);
    }

    public static function sanitizeValue(/*any*/$value, callable $customSanitizationCallable = null) 
    {
        switch (gettype($value)) {
            case 'string':
                return $customSanitizationCallable? $customSanitizationCallable($value) : (function_exists('sanitize_text_field')? sanitize_text_field($value): $value);
                break;
            case 'array':
                return array_map([static::class, 'sanitizeValue'], $value);
                break;
            case 'integer':
            case 'double':
            case 'float':
            default:
                // this is a native PHP non-string numeric, boolean or null 
                // which means it's already been type casted
                // to the correct type
                return $value;
                break;
        }
    }

    public function __construct(array|Collection $map, $securityMode = 'escape')
    {
        $this->mapDefinition = is_array($map)? $map : $map->asArray();
        $this->mappedObjectOnlyWithFieldsFound = new MappedObject;
        $this->securityMode = in_array($securityMode, ['escape', 'sanitize'])? $securityMode : 'escape';
    }

    public function smartMap($value)
    {
        if ((!$this->hasMap()) && $this->isNonJson($value)) {
            return $value;
        } elseif ($this->isObjectOrAssociativeArray($value)) {
            (object) $jsonObject = (object) $value;//$this->getObjectFromJson(Env::getEncoderFunction()($value));
        } else {
            (object) $jsonObject = $this->getObjectFromJson($value);
        }

        return $this->mapObject($jsonObject);   
    }

    public function map($jsonable)
    {
        return $this->mapObject($this->getObjectFromJson((string) $jsonable));
    }

    public function mapObject($parameters)
    {
        (object) $parameters = $this->removeEntriesNotInMap($parameters);

        foreach ($this->mapDefinition as $key => $value) {
            $parameterValue = $this->getAllowedOrDefaultValue($value, $parameters->{$key});

            if (is_array($value)) {
                $parameters->{$key} = $this->recursiveMap($value, $parameterValue);
            } elseif (is_string($value) && is_a($value, Collection::class, $className = true) || $this->valueIs($value, Types::COLLECTION)) {
                (array) $newArray = is_string($parameterValue)? 
                        Collection::createFromString(
                            $parameterValue, 
                            $value instanceof CollectionType? $value->getSeparator() : null
                        ) : (array) $parameterValue;
                (object) $collection = (new Collection($newArray))->filter(function($value) {
                    return is_string($value)? $value !== '' : true;
                })->map([static::class, 'sanitizeValue']);

                $value instanceof CollectionType && $collection->setSeparator($value->getSeparator());

                $parameters->{$key} = $collection;
            } elseif (is_a($value, Mappable::class, $className = true)) {
                $parameters->{$key} = new $value($parameterValue);
            } elseif ($this->valueIs($value, Types::ANY)) {
                $parameters->{$key} = static::sanitizeValue($parameterValue);
            } elseif ($this->valueIs($value, Types::STRING) || Types::isString($value)) {
                (string) $stringValue = (Types::isString($parameterValue) || is_numeric($parameterValue))? (string) $parameterValue : "";

                $parameters->{$key} = new StringManager(
                    static::sanitizeValue($stringValue, $this->getCustomSanitizationFunction($value))
                );
            } elseif ($this->valueIs($value, Types::INTEGER) || $this->valueIs($value, Types::FLOAT) || ((is_integer($value) || is_float($value)) && $value !== Types::BOOLEAN)) {
                if ($this->valueIs($value, Types::INTEGER)) {
                    $earlyValue = (is_integer($parameterValue) || is_numeric($parameterValue))? (integer) $parameterValue : 0;
                } elseif ($this->valueIs($value, Types::FLOAT)) {
                    $earlyValue = (is_float($parameterValue) || is_numeric($parameterValue))? (float) $parameterValue : 0.0;
                }


                if (($value instanceof Types) && $value->hasMinimum()) {
                    (integer) $minimumValue = $value->getOrDefaultToMinimum($earlyValue);
                    $parameters->{$key} = ($earlyValue >= $value->getMinimum())? $minimumValue : max($minimumValue, (integer) $value->getDefaultValue());
                } else {
                    $parameters->{$key} = static::sanitizeValue($earlyValue);
                } 
            } elseif ($this->valueIs($value, Types::BOOLEAN)) {
                $parameters->{$key} = BooleanType::castToExpectedType($parameterValue, $beforeResortingTonull = false);
            }
        }

        $this->mappedObject = $parameters;

        $this->setObjectWithOnlyFieldsFound($parameters);

        return $parameters; 
    }

    protected function setObjectWithOnlyFieldsFound(\StdClass $parameters)
    {
        foreach ($this->mappedObject->mapFieldsFoundInSource->asArray() as $fieldName) {
            $this->mappedObjectOnlyWithFieldsFound->{$fieldName->get()} = $parameters->{$fieldName->get()};
        }   

        $this->mappedObject->setMappedFieldsFound($this->mappedObjectOnlyWithFieldsFound);
    }
    

    protected function recursiveMap(Array $map, $parameterValue)
    {
        (object) $jsonMapper = new static($map);

        return $jsonMapper->smartMap($parameterValue);
    }

    protected function removeEntriesNotInMap($parametersObject)
    {
        (object) $newObject = new MappedObject;

        foreach($this->mapDefinition as $property => $value) {
            if (isset($parametersObject->{$property})) {
                $givenValue = $parametersObject->{$property};
                $newObject->mapFieldsFoundInSource->push(new StringManager($property));
            } else {
                $givenValue = '';
                $newObject->mapFieldsNotFoundInSource->push(new StringManager($property));
            }

            $newObject->{$property} = $givenValue;
        }

        (object) $sourceObject = new Collection((array) $parametersObject);

        $newObject->allFieldsFoundInSource->append(
                                            $sourceObject->getKeys()
                                                         ->filter(S::stringsOnly())
                                                         ->map(function($property){
                                                             return new StringManager($property);
                                                         })
                                                        ->asArray()
                                          );

        $newObject->setRawDataFound(
            new Collection(array_intersect_key((array) $parametersObject, (array) $this->mapDefinition))
        );

        return $newObject;
    }

    protected function getAllowedOrDefaultValue($mapValue, $parameterValue)
    {
        $parameterValue = $this->getOrFallbackToDefaultValue($mapValue,$parameterValue);

        if (($mapValue instanceof Types) && !$mapValue->anyValueIsAllowed()) {
            if ($mapValue instanceof CollectionType) {
                return $mapValue->getCorrectValues($parameterValue);
            }

            if (!$mapValue->getAllowedValues()->contain($parameterValue)) {
                return $mapValue->getFallbackAllowedValue();
            }
        }

        return $parameterValue;
    }

    protected function getEscapeFunction($mapValue) #: callable
    {
        if ($this->valueIs($mapValue, Types::ANY)) {
            return Types::returnValueCallable();
        }

        if ($this->securityMode === 'escape') {
            if ($mapValue instanceof Types && $mapValue->hasDefinedEscapeFunction()) {
                return $mapValue->getEscapeFunction();
            }

            # defaults to wordpress' esc_html($value)
            return function ($value) {
                return esc_html($value);
            };
        } elseif ($this->securityMode === 'sanitize') {
            if ($mapValue instanceof Types && $mapValue->hasDefinedSanitizeFunction()) {
                return $mapValue->getSanitizeFunction();
            }

            # defaults to wordpress' sanitize_text_field($value)
            return function ($value) {
                return sanitize_text_field($value);
            };
        }
    }
    

    protected function getOrFallbackToDefaultValue($mapValue, $parameterValue)
    {
        if (($mapValue instanceof Types)) {
            return $mapValue->pickValue($parameterValue);
        }   

        return $parameterValue;
    }

    protected function valueIs($value, $type)
    {
        if ($value instanceof Types) {
            return $value->is($type);
        }

        return $value === $type;   
    }

    protected function getCustomSanitizationFunction($value)
    {
        if ($value instanceof Types) {
            return $value->getSanitizationFunction();
        }           
    }

    protected function hasMap()
    {
        return $this->mapDefinition !== [];
    }

    protected function isNonJson($value)
    {
        if (is_string($value)) {

            if (empty($value) || trim($value)[0] !== '{') {
                return true;  
            }
            return false;
        } elseif (is_numeric($value) || is_bool($value)) {
            return true;
        } elseif (is_array($value) && (new Collection($value))->isAssociative()) {
            return true;
        }

        return false;
    }

    protected function isObjectOrAssociativeArray($value)
    {
        return is_object($value) || is_array($value);
    } 

    protected function getObjectFromJson($JSONString)
    {
        (string) $json = static::getValidJsonString($JSONString);

        return (object) json_decode($json);
    }

    public static function getValidJsonString($JSONString)
    {
        return static::isInvalidJson($JSONString)? "{}" : $JSONString;
    }

    public static function isInvalidJson($json)
    {
        if (!is_string($json)) return true;
            
        call_user_func_array('json_decode',func_get_args());

        return (json_last_error()!==JSON_ERROR_NONE);
    }

}

