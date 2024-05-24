<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;

class PassedCollection implements GettableCollection
{
    public function __construct(
        protected Collection $collection
    ) {}
    
    public function get(): Collection
    {
        return $this->collection;
    } 
}