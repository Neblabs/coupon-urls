<?php

namespace CouponURLs\Original\Data\Schema\DatabaseColumn;

use CouponURLs\Original\Data\Schema\DatabaseColumn\DatabaseColumnDefault;

Class DatabaseColumnDefaultString extends DatabaseColumnDefault
{
    public function getDefinition()
    {
        return "DEFAULT '{$this->getCleanValue()}'";
    }
}
