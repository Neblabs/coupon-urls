<?php

namespace CouponURLS\Original\Deployment\Files;

use CouponURLS\Original\Deployment\Files\Abilities\FileSystem;
use CouponURLS\Original\Deployment\Files\Abilities\FileSystemValidatorFactory;
use CouponURLS\Original\Validation\Validator;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class ValidatableFilesystem implements FileSystem
{
    public function __construct(
        protected SymfonyFilesystem $filesystem,
        protected FileSystemValidatorFactory $fileSystemValidatorFactory
    ) {}
    
    public function copy($originFile, $targetFile, $overwriteNewerFiles = false)
    {
        $this->fileSystemValidatorFactory->copy($originFile, $targetFile)->validate();

        $this->filesystem->copy($originFile, $targetFile);
    } 

    public function remove($files)
    {
        $this->fileSystemValidatorFactory->remove($files)->validate();

        //$this->filesystem->remove($files);  
    } 

    public function rename($origin, $target, $overwrite = false)
    {
        $this->fileSystemValidatorFactory->rename($origin, $target)->validate();

        $this->filesystem->rename($origin, $target);   
    } 
}