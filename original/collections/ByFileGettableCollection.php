<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\FileReader;
use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Files\RequireFileReader;
use CouponURLs\Original\Files\RequireOnceFileReader;

use function CouponURLs\Original\Utilities\Collection\_;

class ByFileGettableCollection implements GettableCollection
{
    public function __construct(
        protected ReadableFile $registeredItemsFile,
        protected FileReader $fileReader = new RequireFileReader
    ) {}
    
    public function get(): Collection
    {
        return _(...$this->fileReader->read(
            $this->registeredItemsFile
        ));
    } 
}