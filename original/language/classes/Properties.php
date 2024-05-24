<?php

namespace CouponURLs\Original\Language\Classes;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Language\Classes\Property;
use CouponURLs\Original\Language\Types;

Class Properties extends Entities
{
    private $types;

    public function __construct(iterable $entities)
    {
        parent::__construct($entities);
        $this->types = new Types;   
    }
    
    protected function getDomainClass() : string
    {
        return Property::class;   
    }

    public function getAllClassTyped() : Collection
    {
        return $this->entities->filter(function(Property $property) : bool {
            return !$this->types->isNative($property->getShortType());
        });   
    }

    public function getAllClassTypedNoDuplicates() : Collection
    {
        (object) $loadedTypes = new Collection([]);
        return $this->getAllClassTyped()->filter(function(Property $property) use ($loadedTypes) : bool {
            (string) $type = $property->getLongType();

            if ($loadedTypes->have($type)) {
                $isValid = false;
            } else {
                $isValid = true;
            }

            $loadedTypes->push($type);

            return $isValid;
        });   

    }
    
}