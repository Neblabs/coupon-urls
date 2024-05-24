<?php

namespace CouponURLs\App\Creation\Environment;

use CouponURLs\Original\Environment\Abilities\Environment;
use CouponURLs\Original\Environment\Development;
use CouponURLs\Original\Environment\Production;

class EnvironmentFactory
{
    public function create(string $environment) : Environment
    {
        return match($environment) {
            'development' => new Development,
            default => new Production
        };
    }
}