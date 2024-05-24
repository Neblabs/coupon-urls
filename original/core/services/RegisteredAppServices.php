<?php

namespace CouponURLs\Original\Core\Services;

use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Environment\Env;

class RegisteredAppServices implements ReadableFile
{
    public function source(): string
    {
        return Env::appDirectory().'services/services.php';
    } 
}