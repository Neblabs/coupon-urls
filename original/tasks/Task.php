<?php

namespace CouponURLs\Original\Tasks;

use CouponURLs\Original\Collections\Collection;
use Exception;

Abstract Class Task
{
    abstract public function run(Collection $taskData);
}