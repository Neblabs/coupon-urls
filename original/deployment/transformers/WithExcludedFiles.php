<?php

namespace CouponURLS\Original\Deployment\Transformers;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Collections\Collection;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Deployment\Transformers\Abilities\IsDecorator;
use CouponURLS\Original\Deployment\Transformers\Abilities\Transformable;
use CouponURLS\Original\Deployment\Transformers\Abilities\ValidatableTransformable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\ValidWhen;

use function CouponURLS\Original\Utilities\Text\i;

class WithExcludedFiles implements Transformable, ValidatableTransformable, IsDecorator
{
    public function __construct(
        protected Transformable $transformer,
        protected Collection $relativeExcludedFilePaths
    ) {}
    
    public function canBeTransformed(StringManager $fileContents, FileVersions $fileVersions): Validator
    {
        return new ValidWhen(
            $fileVersions->source()->relativePath()->isNotEither($this->relativeExcludedFilePaths)
        );
    } 

    public function transform(StringManager $fileContents, FileVersions $fileVersions): StringManager
    {
        return $this->transformer->transform($fileContents, $fileVersions);
    } 

    public function decorated(): Transformable
    {
        return $this->transformer;
    } 
}