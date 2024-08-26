<?php

namespace CouponURLS\Original\Deployment\Directories;

use CouponURLS\Original\Characters\StringManager;
use SplFileInfo;

use function CouponURLS\Original\Utilities\Text\i;

class File
{
    public function __construct(
        protected SplFileInfo $file,
        protected StringManager $basePath
    ) {}
    
    public function relativePath() : StringManager
    {
        return $this->absolutePath()->replace($this->basePath, '')->trimLeft('/');
    }

    public function absolutePath() : StringManager
    {
        return i($this->file->getPathname())->replace('//', '/');
    }

    public function info() : SplFileInfo
    {
        return $this->file;     
    }
}