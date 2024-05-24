<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Abilities\ValidatableGettableCollection;

use function CouponURLs\Original\Utilities\Collection\_;

class OnlyValidGroupedGettableCollectionComposite implements GettableCollection
{
    public function __construct(
        protected Collection /*<ValidatableGettableCollection>*/ $validatableGettableCollections
    ) {}
    
    public function get(): Collection
    {
        (object) $validGettableCollections = $this->validatableGettableCollections->getThoseThat(
            canBeUsed: null
        );

        return $validGettableCollections->reduce(
            fn(Collection $collections, GettableCollection $gettableCollection) => $collections->append($gettableCollection->get()->ungroup()),
            initial: _()
        )->group();
    } 
}