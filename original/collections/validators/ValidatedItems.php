<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;

class ValidatedItems extends Validator implements GettableCollection
{
    public function __construct(
        protected Collection $items,
        protected Validator $validator
    ) {}
    
    public function get(): Collection
    {
        $this->validator->validate();

        return $this->items;    
    } 

    public function execute(): ValidationResult
    {
        return $this->passWhen($this->validator->isValid());
    } 

    protected function getDefaultException(): Exception
    {
        return $this->validator->getException();       
    } 
}