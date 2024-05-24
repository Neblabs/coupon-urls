<?php

namespace CouponURLs\App\Components\Actions;

use CouponURLs\App\Components\Abilities\ComponentsRegistrator;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\MultipleComponentsProvider;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\App\Components\BaseComponentsRegistrator;
use CouponURLs\App\Components\Actions\ActionComponents;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;

class ActionComponentsRegistrator extends BaseComponentsRegistrator implements ComponentsRegistrator
{
    public function id() : StringManager
    {
        return i('Actions');
    }

    public function canRegisterUsing(MultipleComponentsProvider $multipleComponentsProvider) : bool
    {
        return $multipleComponentsProvider instanceof ActionComponents;
    } 

    /** @param ActionComponents $multipleComponentsProvider */
    protected function componentsToRegister(MultipleComponentsProvider $multipleComponentsProvider) : Collection
    {
        return $multipleComponentsProvider->Actions();
    }

    protected function rulesOf(Collection $componentsToRegister) : Validator
    {
        return new Validators([
            new ItemsAreOnlyInstancesOf(
                items: $componentsToRegister,
                allowedTypes: _(Identifiable::class)
            ),
            new ItemsAreOnlyInstancesOf(
                items: $componentsToRegister,
                allowedTypes: _(Nameable::class)
            ),
        ]);
    }
}