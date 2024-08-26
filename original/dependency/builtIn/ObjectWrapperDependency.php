<?php

namespace CouponURLs\Original\Dependency\Builtin;

use CouponURLS\Original\Dependency\Abilities\StaticType;
use CouponURLS\Original\Dependency\Dependency;
use CouponURLS\Original\Abilities\Cached;
use CouponURLS\Original\Dependency\Abilities\Context;
use CouponURLS\Original\System\ObjectWrapper;

class ObjectWrapperDependency implements Cached, StaticType, Dependency
{
    static public function type(): string
    {
        return ObjectWrapper::class;   
    } 

    public function canBeCreated(Context $context): bool
    {
        return $context->nameIs('wordpressDatabaseWrapper');
    } 

    public function create(): ObjectWrapper
    {
        global $wpdb;

        return new ObjectWrapper($wpdb);
    } 
}