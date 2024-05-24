<?php

namespace CouponURLs\Original\Data\Model;

use CouponURLs\Original\Data\Schema\DatabaseTable;

Abstract Class Model
{
    abstract public function getDomainClass() : string;
    abstract public function getDomainsClass() : string;
    abstract public function getSchema() : Schema;
}