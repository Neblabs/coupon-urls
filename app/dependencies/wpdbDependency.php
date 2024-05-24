<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Abilities\Cached;
use wpdb;

class wpdbDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    static public function type(): string
    {
        return wpdb::class;   
    } 

    public function create(): wpdb
    {
        return $GLOBALS['wpdb'];
    } 
}