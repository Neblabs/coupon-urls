<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;

class UnknownContext implements Context
{
    public function classIs(string $fullyQualifiedClassName) : bool
    {
        return false;
    }

    public function methodIs(string $name) : bool
    {
        return false;
    }

    public function nameIs(string $variableName) : bool
    {
        return false;
    }

}