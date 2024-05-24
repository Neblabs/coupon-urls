<?php

namespace CouponURLs\Original\Events\Wordpress\Framework;

use CouponURLs\Original\Collections\Abilities\ValidatableGettableCollection;
use CouponURLs\Original\Collections\ByFileGettableCollection;

class AppGlobalSubscribers extends ByFileGettableCollection implements ValidatableGettableCollection 
{
    public function canBeUsed(): bool
    {
        return true;
    } 
}