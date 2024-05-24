<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Actions\Abilities\ActionRunner;
use CouponURLs\Original\Collections\Collection;

class ActionsRunnerComposite implements ActionRunner
{
    public function __construct(
        protected Collection /*<ActionRunner>*/ $actionRunners
    ) {}
    
    public function canRun(Actionable|RestrictableAction $action): bool
    {
        return $this->actionRunners->haveAny();
    } 

    public function run(Actionable|RestrictableAction $action): void
    {   
        /** @var ActionRunner */
        (object) $runner =  $this->actionRunners->findTheOneThat(canRun: $action);

        $runner->run($action);
    } 
}