<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;

class PostTypeURL implements URL
{
    public function __construct(
        protected int $postId
    ) {}
    
    public function get(): string
    {
        return get_permalink($this->postId);
    } 
}