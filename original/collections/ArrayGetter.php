<?php

namespace CouponURLs\Original\Collections;

use BadMethodCallException;
use CouponURLs\Original\Collections\Abilities\ArrayRepresentation;

Class ArrayGetter
{
    public static function getArrayOrThrowExceptionFrom($value)
    {
        if (is_array($value) ) {
            return $value;
        } elseif ($value instanceof ArrayRepresentation){
            return $value->asArray();
        }

        throw new BadMethodCallException("Error: method expects parameter to be array or ArrayRepresentation, ".gettype($value).' given.');
        
    }

    public static function getFlattenArrayOrThrowExceptionFrom($value)
    {
        /*array|null*/ $arrayValue = static::getArrayOrThrowExceptionFrom($value);

        return $arrayValue? array_map(Collection::convertToString(), $arrayValue) : null;
    }
    

    public static function isArrayRepresentation($value)
    {
        return is_array($value) || $value instanceof ArrayRepresentation; 
    }
}