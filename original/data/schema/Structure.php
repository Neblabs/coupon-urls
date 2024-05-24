<?php

namespace CouponURLs\Original\Data\Schema;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Schema\Abilities\StructureIdentifier;

abstract class Structure
{
    abstract public function name() : string;
    abstract public function fields() : Fields;
}