<?php

namespace CouponURLS\Original\Deployment\Transformers;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Deployment\Transformers\Abilities\IsDecorator;
use CouponURLS\Original\Deployment\Transformers\Abilities\Transformable;
use CouponURLS\Original\Deployment\Transformers\Abilities\ValidatableTransformable;
use CouponURLS\Original\Validation\Validator;

use function CouponURLS\Original\Utilities\Text\i;

class ConditionalTransformer implements Transformable, ValidatableTransformable, IsDecorator
{
    public function __construct(
        protected Transformable $transformer,
        protected ValidatableTransformable $transformerValidator
    ) {}
    
    public function canBeTransformed(StringManager $fileContents, FileVersions $fileVersions): Validator
    {
        return $this->transformerValidator->canBeTransformed($fileContents, $fileVersions);
    } 

    public function transform(StringManager $fileContents, FileVersions $fileVersions): StringManager
    {
        if (!$this->canBeTransformed($fileContents, $fileVersions)->isValid()) {
            return $fileContents;
        }

        return $this->transformer->transform($fileContents, $fileVersions);
    } 

    public function decorated(): Transformable
    {
        return $this->transformer;
    } 
}