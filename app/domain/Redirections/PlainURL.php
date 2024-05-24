<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;

class PlainURL implements URL
{
    public function __construct(
        protected string $url
    ) {}
    
    public function get(): string
    {
        return $this->url;
    } 
}