<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entity;

interface CanCreateEntityWithParameters
{
    public function createEntity(mixed $data, Parameters $parameters) : Entity;
}