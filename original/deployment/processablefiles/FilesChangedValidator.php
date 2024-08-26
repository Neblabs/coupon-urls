<?php

namespace CouponURLS\Original\Deployment\Processablefiles;

use CouponURLS\Original\Deployment\Files\Files;
use CouponURLS\Original\Executable\Abilities\Validatable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\ValidWhen;

class FilesChangedValidator implements Validatable
{
    public function __construct(
        protected Files $files
    ) {}
    
    public function canBeExecuted(): Validator
    {
        return new ValidWhen($this->files->haveChanged());
    } 
}