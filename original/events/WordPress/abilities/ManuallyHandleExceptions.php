<?php

namespace CouponURLs\Original\Events\Wordpress\Abilities;

use Throwable;

interface ManuallyHandleExceptions
{
    public function onException(Throwable $exception) : mixed;
}