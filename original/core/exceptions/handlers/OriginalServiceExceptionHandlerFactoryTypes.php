<?php

namespace CouponURLs\Original\Core\Exceptions\Handlers;

use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Environment\Env;

class OriginalServiceExceptionHandlerFactoryTypes implements ReadableFile
{
    public function source(): string
    {
        return Env::originalDirectory().'/core/exceptions/handlers/register.php';
    } 
}