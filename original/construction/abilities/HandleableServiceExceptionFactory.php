<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Core\Abilities\HandleableServiceException;

interface HandleableServiceExceptionFactory
{
    public function create() : HandleableServiceException; 
}