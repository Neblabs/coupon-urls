<?php

namespace CouponURLs\Original\Data\Schema\Abilities;

use CouponURLs\Original\Characters\StringManager;

interface StructureField
{
    public function name() : StringManager;
    public function is(string $name) : bool;
}