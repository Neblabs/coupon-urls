<?php

namespace CouponURLs\Original\Abilities;

use Attribute;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

#[Attribute]
class Methods
{
    public function __construct(
        protected array $names
    ) {}

    public function names() : Collection
    {
        return _($this->names);
    }
}