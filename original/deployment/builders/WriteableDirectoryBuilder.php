<?php

namespace CouponURLS\Original\Deployment\Builders;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Directories\Directories;
use CouponURLS\Original\Executable\Abilities\Executable;
use CouponURLS\Original\Executable\Abilities\Validatable;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators\ValidWhen;

class WriteableDirectoryBuilder implements Executable, Validatable
{
    public function __construct(
        protected StringManager $target,
        protected bool $override = false
    ) {}

    public function canBeExecuted(): Validator
    {
        return new ValidWhen($this->override === false && is_dir($this->target));
    }     

    public function execute()
    {
        mkdir(
            directory: dd($this->target, 'making!'),
            recursive: true
        );
    } 
}