<?php

namespace CouponURLs\Original\Creation\Entities\Abilities;

interface OverloadableEntitiesFactory
{
    public function canCreateEntities(mixed $data) : bool;
    public function canCreateEntity(mixed $data) : bool;
}