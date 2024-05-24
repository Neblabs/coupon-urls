<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;

interface Dependency
{
    public function create() : object;
    public function canBeCreated(Context $context) : bool;
}