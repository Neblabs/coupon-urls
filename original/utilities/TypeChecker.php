<?php

namespace CouponURLs\Original\Utilities;

use CouponURLs\Original\Utilities\ConcreteTypeChecker;

Trait TypeChecker
{
    protected static function expectValue($value)
    {
        return new ConcreteTypeChecker($value);
    }

    /* 
        The key here is we are type hinting the array, if we used the above method we wouldn't be able to enforce the value to be an array
    */
    protected static function expectEachValue(array $values)
    {
        return new ConcreteTypeChecker($values);
    }

    protected function expect($value)
    {
        return static::expectValue($value);
    }

    /* 
        The key here is we are type hinting the array, if we used the above method we wouldn't be able to enforce the value to be an array
    */
    protected function expectEach(/*Collection|array*/ $values) {
        return static::expectValue($values);
    }
}