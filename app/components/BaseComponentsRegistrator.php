<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\MultipleComponentsProvider;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ValidatedItems;
use CouponURLs\Original\Validation\Validator;

abstract class BaseComponentsRegistrator
{
    abstract protected function rulesOf(Collection $componentsToRegister) : Validator;
    abstract protected function componentsToRegister(MultipleComponentsProvider $multipleComponentsProvider) : Collection;

    public function __construct(
        protected Components $components
    ) {}
    
    public function components() : Components
    {
        return $this->components;
    } 

    public function registerUsing(MultipleComponentsProvider $multipleComponentsProvider) : void
    {
        (object) $componentsToRegister = $this->componentsToRegister($multipleComponentsProvider);

        $this->components->add(new ValidatedItems(
            items: $componentsToRegister,
            validator: $this->rulesOf($componentsToRegister)
        ));
    }
}