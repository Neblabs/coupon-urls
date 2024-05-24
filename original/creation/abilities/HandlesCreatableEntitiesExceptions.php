<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;
use Throwable;

interface HandlesCreatableEntitiesExceptions
{
    public function handleCreateEntityException(Throwable $exception, mixed $data) : ?Entity;
    public function handleCreateEntitiesException(Throwable $exception, mixed $entitesData) : ?Entities;
}