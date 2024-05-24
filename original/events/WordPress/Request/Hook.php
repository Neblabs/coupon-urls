<?php

namespace CouponURLs\Original\Events\Wordpress\Request;

use CouponURLs\Original\Events\Subscriber;

Abstract Class Hook
{
    abstract public function type() : string;

    public function __construct(
        protected string $name
    )
    {}

    public function name() : string
    {
        return $this->name;   
    }
}