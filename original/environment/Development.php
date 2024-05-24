<?php

namespace CouponURLs\Original\Environment;

use CouponURLs\Original\Environment\Abilities\Environment;
use CouponURLs\Original\Environment\Env;

class Development implements Environment
{
    public function isProduction(): bool
    {
        return false;
    } 

    public function isDevelopment(): bool
    {
        return true;   
    }

    public function isTesting(): bool
    {
        return false;
    } 
}