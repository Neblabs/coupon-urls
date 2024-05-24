<?php

namespace CouponURLs\Original\Dependency;

interface ContainableDependencies
{
    public function get(string $type) : object;
}