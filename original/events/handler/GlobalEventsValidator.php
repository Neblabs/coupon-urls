<?php

namespace CouponURLs\Original\Events\Handler;

Abstract Class GlobalEventsValidator
{
    abstract public function canBeExecuted() : bool;
}