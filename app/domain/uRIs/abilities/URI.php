<?php

namespace CouponURLs\App\Domain\Uris\Abilities;

use CouponURLs\App\Domain\Uris\QueryParameters;

interface URI
{
    public function type() : string;
    public function value() : string|int;
    public function queryParameters() : QueryParameters; 
}