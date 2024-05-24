<?php

namespace CouponURLs\Original\Data\Instructions;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;

Abstract Class Instruction
{
    abstract public function shouldGet() : bool;

    protected /*StringManager*/ $statement;
    protected /*Collection*/    $parameters;

    public function getStatement() : StringManager
    {
        return $this->statement;
    }

    public function getParameters() : Collection
    {
        return $this->parameters;
    }
}