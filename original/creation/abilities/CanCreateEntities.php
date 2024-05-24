<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Domain\Entities;

interface CanCreateEntities
{
    public function createEntities(mixed $entitesData) : Entities;
}