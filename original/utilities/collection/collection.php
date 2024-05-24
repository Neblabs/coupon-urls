<?php

namespace CouponURLs\Original\Utilities\Collection {
    use CouponURLs\Original\Collections\Collection;
    use stdClass;

    /**
     * Used *directly* in development only!
     * This is consider protected in production!
     */
    function _(...$items) : Collection {
        if (count($items) === 1 && isset($items[0]) && (is_array($items[0]) || $items[0] instanceof Collection)) {
            return new Collection($items[0]);
        }
        return new Collection($items ?? []);
    }

    function _a(array $array) : Collection {
        return new Collection($array);
    }

    function a(...$array) : array {
        return $array;
    }

    function o(...$array) : stdClass {
        return (object) a(...$array);
    }
}


namespace {

    use CouponURLs\Original\Collections\Collection;
    use function CouponURLs\Original\Utilities\Collection\_;

    if(!function_exists('neblabs_collection')) {
        /**
         * Used in production builds only!
         */
        function neblabs_collection(array $collection = []) : Collection {
            if (count($collection) === 1 && isset($collection[0]) && (is_array($collection[0]) || $collection[0] instanceof Collection)) {
                return new Collection($collection[0]);
            }
            return new Collection($collection ?? []);
        }
    }
}