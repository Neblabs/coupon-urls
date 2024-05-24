<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Utilities\TypeChecker;

Class JSONObjectsContainer
{
    use TypeChecker;
    
    const FIELD_TO_SEARCH = 'type';

    protected static function objects()       
    {
        return [
        ];
    }

    public static function getObjects()
    {
        return (new Collection((array) static::objects()))->map(function($element){
            return new Collection($element);
        });
    }

    public static function get($value)
    {
        (object) $objects = static::getObjects()->filter(function(Collection $object) use ($value) {
            (string) $field = static::FIELD_TO_SEARCH;
            return $object->get($field) === $value;
        });

        return $objects->haveAny()? $objects->first() : null;
    }
}



