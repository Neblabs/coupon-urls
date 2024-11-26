<?php

namespace CouponURLs\Original\Events;

use CouponURLs\Original\Abilities\DuckInterface;
use CouponURLs\Original\Abilities\Methods;

#[DuckInterface]
#[Methods([
    'canBeRegistered', 
])]
/**
 * @method mixed canBeRegistered()
 */
Interface OptionalRegisterableSubscriber
{
    /**
     * THEY ALL NEED BE PUBLIC!
     */
    /* static public function canBeRegistered([...]) : Validator; */
}