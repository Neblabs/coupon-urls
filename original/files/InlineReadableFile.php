<?php

namespace CouponURLs\Original\Files;

use CouponURLs\Original\Abilities\ReadableFile;

class InlineReadableFile implements ReadableFile
{
    public function __construct(
        protected string $filePath
    ) {}
    
    public function source(): string
    {
        return $this->filePath;
    } 
}