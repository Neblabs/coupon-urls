<?php

namespace CouponURLs\Original\Data\Schema\DatabaseColumn;

use CouponURLs\Original\Characters\StringManager;

Abstract Class DatabaseColumnDefault
{
    protected $value;

    abstract public function getDefinition();

    public function __construct($value = null)
    {
        $this->value = $value;
    }
    
    protected function getCleanValue()
    {
        return (new StringManager($this->value))->getOnly('A-Za-z0-9_() ');   
    }
}
