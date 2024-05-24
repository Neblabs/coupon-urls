<?php

namespace CouponURLs\App\Domain\URIs;

use CouponURLs\App\Domain\Uris\Abilities\URI;

Class PathURI extends BaseURI implements URI
{
    public function type(): string
    {
        return 'path';
    } 
}