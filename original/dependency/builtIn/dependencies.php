<?php

use CouponURLs\Original\Dependency\BuiltIn\HooksDependency;
use CouponURLs\Original\Dependency\BuiltIn\RegisteredSubscribersDependency;
use CouponURLs\Original\Dependency\BuiltIn\HookFactoryDependency;
use CouponURLs\Original\Dependency\BuiltIn\SubscriberFactoryDependency;
use CouponURLs\Original\Dependency\BuiltIn\ErrorHandlerDependency;
use CouponURLS\Original\Dependency\Builtin\ObjectWrapperDependency;
use CouponURLs\Original\Dependency\BuiltIn\WordPressPostReadableDriverDependency;

return [
    //The original deps,
    HooksDependency::class,
    RegisteredSubscribersDependency::class,
    HookFactoryDependency::class,
    SubscriberFactoryDependency::class,
    ErrorHandlerDependency::class,
    ObjectWrapperDependency::class,
    WordPressPostReadableDriverDependency::class,
];