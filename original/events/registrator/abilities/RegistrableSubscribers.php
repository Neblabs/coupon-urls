<?php

namespace CouponURLs\Original\Events\Registrator\Abilities;

use CouponURLs\Original\Events\Subscribers;

interface RegistrableSubscribers
{
    public function register(Subscribers $subscribers);
}