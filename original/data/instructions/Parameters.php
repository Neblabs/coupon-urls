<?php

namespace CouponURLs\Original\Data\Instructions;

use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;

class Parameters
{
    protected Collection $parameters;

    public function __construct(
    )
    {
        $this->parameters = _();
    }

    public function addParameter(Parameter $parameter) : void
    {
        $this->parameters->add($parameter);
    }
}