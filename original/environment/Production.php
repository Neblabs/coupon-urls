<?php

namespace CouponURLs\Original\Environment;

use CouponURLs\Original\Environment\Abilities\Environment;
use CouponURLs\Original\Environment\Env;

class Production implements Environment
{
    public function isProduction(): bool
    {
        return true;
    } 

    public function isDevelopment(): bool
    {
        return false;   
    }

    public function isTesting(): bool
    {
        return false;
    } 
}