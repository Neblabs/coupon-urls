<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Data\Savers\Abilities\Saveable;
use CouponURLs\Original\Collections\Collection;

class SaverComposite implements Saveable
{
    public function __construct(
        protected Collection /*<Saveable>*/ $saveables
    ) {}
    
    public function save(mixed $data)
    {
        $this->saveables->perform(save: $data);
    } 
}