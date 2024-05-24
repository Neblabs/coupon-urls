<?php

namespace CouponURLs\Original\Events\Wordpress\Abilities;

use Throwable;

interface ExceptionHandler
{
    public function handle(Throwable $exception);
}