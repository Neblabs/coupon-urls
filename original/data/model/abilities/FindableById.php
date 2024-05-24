<?php

namespace CouponURLs\Original\Data\Model\Abilities;

use CouponURLs\Original\Domain\Entity;

interface FindableById
{
    public function withId(int $id) : Entity;
} 