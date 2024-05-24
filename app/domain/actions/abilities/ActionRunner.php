<?php

namespace CouponURLs\App\Domain\Actions\Abilities;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\Original\Collections\Collection;

interface ActionRunner
{
    public function canRun(Actionable|RestrictableAction $action) : bool;
    public function run(Actionable|RestrictableAction $action) : void;
}