<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

class OverloadableActionsDecorator implements Actionable, RestrictableAction
{
    public function __construct(
        protected Collection /*<Actionable&RestrictableAction>*/ $restrictableActions
    ) {}
    
    public function canPerform(): Validator
    {
        return new ValidWhen(
            (boolean) $this->pickTheValidAction()
        );
    } 

    public function perform(): void
    {
        $this->pickTheValidAction()->perform();
    } 

    public function pickTheValidAction() : ?Actionable
    {
        return $this->restrictableActions->find(
            fn(RestrictableAction $action) => $action->canPerform()->isValid()
        );
    }
}