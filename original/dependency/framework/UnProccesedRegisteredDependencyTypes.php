<?php

namespace CouponURLs\Original\Dependency\Framework;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\GettableCollectionDecorator;

class UnProccesedRegisteredDependencyTypes implements GettableCollection
{
    public function get(): Collection
    {
        (object) $registeredTypes = new GettableCollectionDecorator(
            new ByFileGettableCollection(
                new OriginalDependencyTypes
            ),
            new ByFileGettableCollection(
                new AppDependencyTypes
            )
        );

        return $registeredTypes->get();
    } 
}