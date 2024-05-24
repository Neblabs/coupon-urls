<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Collection;

/**
 * Though not obvious at first, this class
 * allows you to merge an infinite number of collections
 */
class GettableCollectionDecorator implements GettableCollection
{
    public function __construct(
        protected GettableCollection $parentGettableCollection,
        protected GettableCollection $childGettableCollection
    ) {}

    public function get(): Collection
    {
        return $this->parentGettableCollection->get()->append(
            $this->childGettableCollection->get()
        );
    } 
}