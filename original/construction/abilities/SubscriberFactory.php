<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Events\Subscriber;

interface SubscriberFactory
{
    public function create(string $ubscriberType) : Subscriber;
}