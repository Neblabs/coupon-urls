<?php

namespace CouponURLs\Original\Language;

class CallableBuilder
{
    public function __construct(
        protected object $object
    ) {}
    
    public function __call($name, $arguments) : callable
    {
        $bindedArguments = $arguments;

        return fn(...$callbackArguments) => $this->object->{$name}(...array_filter([
            ...$bindedArguments,
            ...$callbackArguments
        ]));
    } 
}