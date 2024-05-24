<?php

namespace CouponURLs\Original\Dependency\Framework;

use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Environment\Env;

class AppDependencyTypes implements ReadableFile
{
    public function source(): string
    {
        return Env::appDirectory().'dependencies/register.php';
    } 
}