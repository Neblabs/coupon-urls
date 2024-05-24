<?php

namespace CouponURLs\App\Domain\Actions\Redirections;

use CouponURLs\Original\Domain\Entities;

Class Redirections extends Entities
{
    protected function getDomainClass() : string
    {
        return Redirection::class;
    }
}