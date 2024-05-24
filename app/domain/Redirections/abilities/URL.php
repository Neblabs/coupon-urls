<?php

namespace CouponURLs\App\Domain\Redirections\Abilities;

interface URL
{
    /**
     * Should be UNESCPAED!
     */
    public function get() : string; 
}