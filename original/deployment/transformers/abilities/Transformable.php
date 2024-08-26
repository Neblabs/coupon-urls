<?php

namespace CouponURLS\Original\Deployment\Transformers\Abilities;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Files\FileVersions;

interface Transformable
{
    public function transform(StringManager $fileContents, FileVersions $fileVersions) : StringManager;
}