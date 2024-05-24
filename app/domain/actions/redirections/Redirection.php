<?php

namespace CouponURLs\App\Domain\Actions\Redirections;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Redirections\Abilities\Redirectable;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

Class Redirection implements Actionable, RestrictableAction
{
    public function __construct(
        protected Redirectable $redirector
    ) {}
    
    public function canPerform(): Validator
    {
        return new ValidWhen($this->redirector->canRedirect());
    } 

    public function perform(): void
    {
        $this->redirector->redirect();
    } 
}