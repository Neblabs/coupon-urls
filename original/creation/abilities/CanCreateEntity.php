<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Domain\Entity;

interface CanCreateEntity
{
    public function createEntity(mixed $data) : Entity;
}