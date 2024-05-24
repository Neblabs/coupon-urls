<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Actions\Abilities\ActionRunner;

class NonRestrictableActionRunner implements ActionRunner
{
    public function canRun(Actionable|RestrictableAction $action): bool
    {
        return !$action instanceof RestrictableAction;
    } 

    public function run(Actionable|RestrictableAction $action): void
    {
        $action->perform();
    } 
}