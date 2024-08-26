<?php

namespace CouponURLS\Original\Deployment\Transformers\Abilities;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Validation\Validator;

interface ValidatableTransformable
{
    public function canBeTransformed(StringManager $fileContents, FileVersions $fileVersions) : Validator;
}