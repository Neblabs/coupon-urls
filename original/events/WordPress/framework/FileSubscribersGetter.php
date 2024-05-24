<?php

namespace CouponURLs\Original\Events\Wordpress\Framework;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\Collection;

class FileSubscribersGetter implements GettableCollection
{
    public function __construct(
        protected ReadableFile $source
    ) {}
    
    public function get(): Collection
    {
        (object) $fileGettableCollection = new ByFileGettableCollection(
            $this->source
        );

        return $fileGettableCollection->get();
    } 
}