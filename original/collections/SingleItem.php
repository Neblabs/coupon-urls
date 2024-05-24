<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;

use function CouponURLs\Original\Utilities\Collection\_;

class SingleItem implements GettableCollection
{
    public function __construct(
        protected mixed $item
    ) {}
    
    public function get(): Collection
    {
        return _($this->item);
    } 
}