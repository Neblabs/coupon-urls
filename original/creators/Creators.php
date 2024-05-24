<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Abilities\Creator;

Abstract Class Creators implements Creator
{
    abstract protected function getCreators() : Collection;

    public function create()
    {
        foreach ($this->getCreators() as $creator) {
            $creator->create();
        }
    }
}