<?php

namespace CouponURLs\Original\Dependency\Framework;

use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Environment\Env;

class OriginalDependencyTypes implements ReadableFile
{
    public function source(): string
    {
        return Env::originalDirectory().'dependency/builtin/dependencies.php';
    } 
}