<?php

namespace CouponURLS\Original\Deployment\Builders;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Collections\Collection;
use CouponURLS\Original\Deployment\Transformers\Abilities\Transformable;
use CouponURLS\Original\Deployment\Directories\Directories;
use CouponURLS\Original\Deployment\Files\Abilities\FileSystem;
use CouponURLS\Original\Deployment\Files\Files;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Executable\Abilities\Executable;
use CouponURLS\Original\Executable\Abilities\Validatable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\PassingValidator;

use function CouponURLS\Original\Utilities\Text\i;

class TransformersBuilder implements Executable, Validatable
{
    public function __construct(
        protected Directories $directories,
        protected Files $files,
        protected FileSystem $filesystem,
        protected Collection $transformers
    ) {}
    
    public function canBeExecuted(): Validator
    {
        //mayeb obly if the console has that flag?
        return new PassingValidator;    
    } 

    public function execute()
    {
        print 'running transformer scripts...';

        $this->files->changed->forEvery(function(FileVersions $fileVersions) {
            (object) $transformedFileContent = $this->transformers->reduce(
                fn(StringManager $fileContents, Transformable $transformer) => $transformer->transform(
                    $fileContents, 
                    $fileVersions
                ), 
                initial: i(file_get_contents($fileVersions->source()->absolutePath()))
            );

            // and after all, we'll upadte the contents to the trasnformed file in transformed/fielname.php 
            dd('updating', (string) $transformedFileContent);
        }); 
    } 
}