<?php

namespace CouponURLs\Original\Events\Wordpress\Framework;

use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Environment\Env;

class OriginalSubscribers implements ReadableFile
{
    public function source(): string
    {
        return Env::originalDirectory().'subscribers/actions.php';
    } 
}