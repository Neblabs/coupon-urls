<?php

namespace CouponURLS\Original\Deployment\Files;

use CouponURLS\Original\Deployment\Directories\Directories;
use CouponURLS\Original\Deployment\Files\Abilities\FileSystemValidatorFactory;
use CouponURLS\Original\Deployment\Files\Exceptions\UnwriteableSourceException;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators;
use CouponURLS\Original\Validation\Validators\ValidWhen;
use Exception;

use function CouponURLS\Original\Utilities\Text\i;
use function CouponURLS\Original\Utilities\Collection\_;

class UnwriteableSourceFileSystemValidatorFactory implements FileSystemValidatorFactory
{
    public function __construct(
        protected Directories $directories
    ) {}
    
    public function copy($originFile, $targetFile) : Validator
    {
        return $this->isNotInTargetDirectory($targetFile);
    }

    public function remove($files) : Validator
    {
        return new Validators(_($files)->map($this->isNotInTargetDirectory(...)));
    } 

    public function rename($origin, $target, $overwrite = false) : Validator
    {
        return $this->isNotInTargetDirectory($target);
    } 

    protected function isNotInTargetDirectory($targetFile) : Validator
    {
        return new ValidWhen(
            !i($targetFile)->contains($this->directories->source(), caseSensitive: false),
            exception: new UnwriteableSourceException("Trying to write to the source: {$targetFile}")
        );
    }
    
}