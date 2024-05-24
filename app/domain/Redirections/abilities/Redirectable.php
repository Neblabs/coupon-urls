<?php

namespace CouponURLs\App\Domain\Redirections\Abilities;

interface Redirectable
{
    public function canRedirect(): bool;
    public function redirect() : void;
}