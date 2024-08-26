<?php

namespace CouponURLS\Original\Deployment\Transformers\Attributes;

use Attribute;
use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Deployment\Transformers\Abilities\ValidatableTransformable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\ValidWhen;


#[Attribute]
class NotVendor implements ValidatableTransformable
{
    public function canBeTransformed(StringManager $fileContents, FileVersions $fileVersions): Validator
    {
        // here we make sure its not part of the excluded files
        return new ValidWhen(
            !$fileVersions->source()->relativePath()->contains('vendor/')
        );
    } 
}