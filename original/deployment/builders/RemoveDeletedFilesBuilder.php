<?php

namespace CouponURLS\Original\Deployment\Builders;

use CouponURLS\Original\Collections\Collection;
use CouponURLS\Original\Deployment\Directories\Directories;
use CouponURLS\Original\Deployment\Directories\File;
use CouponURLS\Original\Deployment\Files\Abilities\FileSystem;
use CouponURLS\Original\Deployment\Files\Files;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Executable\Abilities\Executable;

class RemoveDeletedFilesBuilder implements Executable
{
    public function __construct(
        protected Directories $directories,
        protected Files $files,
        protected FileSystem $filesystem
    ) {}
    
    public function execute()
    {
        print 'removing deleted files...';

        foreach ($this->files->deleted->asArray() as $fileVersions) {
            $this->filesystem->remove($fileVersions->mirror()->absolutePath()); 
        }
    } 
}