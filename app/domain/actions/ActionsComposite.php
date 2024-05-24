<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;
#Composite
class ActionsComposite implements Actionable
{
    public function __construct(
        protected Collection /*<ComponentExportable>*/ $actions,
        protected ActionsRunnerComposite $actionsRunner
    ) {}

    public function add(Actionable $action) : void
    {
        $this->actions->push($action);
    }

    public function perform(): void
    {
        $this->performExcept(_());
    } 

    public function performExcept(Collection $actionTypes) : void
    {
        $this->actions
            /*->filter(
                fn(Actionable $action) => $actionTypes->doesNotHave(
                    //what is this weird thing going on here?
                    fn(string $actionType) => !$actionType instanceof $actionType
                )
            )*/
            ->forEvery($this->actionsRunner->run(...));
    }
}