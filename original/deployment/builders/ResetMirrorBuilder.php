<?php

namespace CouponURLS\Original\Deployment\Builders;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Directories\Directories;
use CouponURLS\Original\Deployment\Directories\File;
use CouponURLS\Original\Deployment\Files\Abilities\FileSystem;
use CouponURLS\Original\Deployment\Files\Files;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Executable\Abilities\Executable;
use CouponURLS\Original\Executable\Abilities\Validatable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\PassingValidator;

class ResetMirrorBuilder implements Executable, Validatable
{
    public function __construct(
        protected Directories $directories,
        protected Files $files,
        protected FileSystem $filesystem
    ) {}
    
    public function canBeExecuted(): Validator
    {
        //mayeb obly if the console has that flag?
        return new PassingValidator;    
    } 

    public function execute()
    {
        print 'creating mirror files...';

        $this->filesystem->remove($this->directories->mirror()->get());

        $this->files->allSourceFilesToCopy()->forEvery(function(FileVersions $fileVersions) {
            $this->filesystem->copy(
                originFile: $fileVersions->source()->absolutePath(),
                targetFile: $fileVersions->mirror()->absolutePath()
            );
        });
    } 
}