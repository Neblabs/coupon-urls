<?php

namespace CouponURLs\Original\Dependency\BuiltIn;

use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Data\WP_QueryFactory;
use CouponURLs\Original\Data\Drivers\Wordpress\WordPressPostReadableDriver;

class WordPressPostReadableDriverDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    static public function type(): string
    {
        return WordPressPostReadableDriver::class;   
    } 

    public function create(): WordPressPostReadableDriver
    {
        return new WordPressPostReadableDriver(
            new WP_QueryFactory
        );
    } 
}