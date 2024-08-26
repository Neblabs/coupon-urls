<?php

namespace CouponURLS\Original\Deployment\Transformers\Attributes;

use Attribute;
use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Collections\Collection;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Deployment\Transformers\Abilities\ValidatableTransformable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\ValidWhen;

use function CouponURLS\Original\Utilities\Collection\_;

#[Attribute]
class OnlyExtensions implements ValidatableTransformable
{
    protected Collection $extensions;

    public function __construct(
        array $extensions
    ) {
        $this->extensions = _($extensions);
    }
    
    public function canBeTransformed(StringManager $fileContents, FileVersions $fileVersions): Validator
    {
        // here we make sure its not part of the excluded files
        return new ValidWhen(
            $this->extensions->have($fileVersions->source()->relativePath()->endsWith(...))
        );
    } 
}