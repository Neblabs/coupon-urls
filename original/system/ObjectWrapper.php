<?php

namespace CouponURLs\Original\System;

class ObjectWrapper
{
    public function __construct(
        protected object $object
    ) {}
    
    public function call(string $method, ...$arguments) : mixed
    {
        // make it an indexed array so that we don't pass named arguments in php less than 8
        if (is_array($arguments)) {
            $arguments = array_values($arguments);
        }
        return $this->object->{$method}(...$arguments);
    }
}