<?php

namespace CouponURLs\Original\Presentation;

use CouponURLs\Original\Collections\Collection;

Class AttributesManager
{
    public function build(Array $attribute)
    {
        (array) $attribute = (new Collection($attribute))->mapWithKeys(function($value, $name){
            return [
                'key' => $name,
                'value' => esc_attr($value)
            ];
        })->asArray();

        return trim($attribute['value'])? " {$attribute['name']}=\"{$attribute['value']}\"" : '';
    }
}