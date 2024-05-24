<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entities;

interface CanCreateEntitiesWithParameters
{
    public function createEntities(mixed $entitesData, Parameters $parameters) : Entities;
}