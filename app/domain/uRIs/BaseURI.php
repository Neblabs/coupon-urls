<?php

namespace CouponURLs\App\Domain\URIs;

use CouponURLs\App\Domain\Uris\QueryParameters;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Domain\Entity;

Abstract class BaseURI extends Entity implements URI
{
    public function __construct(
        protected QueryParameters $queryParameters,
        protected $value = '',
    ) {}
    
    public function value() : string|int
    {
        return $this->value;
    }

    public function queryParameters(): QueryParameters
    {
        return $this->queryParameters;
    } 
}