<?php

namespace CouponURLs\Original\Utilities;

Class ObjectSetter
{
    /**
     * Safely maps an associative array to a target object,
     * setting the array keys as the object's public properties.
     * This is a safe way to not bypass property visibilty when
     * attempting to set non-public properties using an array element with a key with the name 
     * of a non-public property 
     * @param Array $objectAndValues The object to set the values to and an associative array 
     * of values
     */
    public static function setPublicValues(Array $objectAndValues)
    {
        (object) $objectToSetPropertiesTo = $objectAndValues['object'];
        (array) $values = $objectAndValues['values'];

        foreach ($values as $key => $value) {
            $objectToSetPropertiesTo->{$key} = $value;
        }
    }
    
}