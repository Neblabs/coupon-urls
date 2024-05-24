<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

/**
 * Similar to a collection, but mtulidemsional arrays will be converted to
 * object so that you may access them using the object accesor operator ->
 */
Class EventArguments extends Collection
{
    public function __construct(/*Array|Collection*/ $elements)
    {
        $elements = _($elements)->asArray();

        parent::__construct($elements);
        /**
         * Calling the parent twice is not a mistake.
         * We'll let the original constructor convert the elements to the expected format
         * instead of duplicating the logic here, because $elements may be a collection or an array.
         */
        parent::__construct(
            $this->convertToObject($elements)
        );
    }
    
    public function convertToObject(array $items) : mixed 
    {
        $arrayIsListFunction = function (array $array) : bool {
             if (function_exists('array_is_list')) {
                 return array_is_list($array);
             }
             if ($array === []) {
                 return true;
             }
             $current_key = 0;
             foreach ($array as $key => $noop) {
                 if ($key !== $current_key) {
                     return false;
                 }
                 ++$current_key;
             }
             return true;
         };

        return array_map(
            fn(mixed $item) => is_array($item) && !$arrayIsListFunction($item)? (object) $this->convertToObject($item) : ($item), 
            $items
        );
    } 



}