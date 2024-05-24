<?php

use CouponURLs\Original\Commands\BuiltIn\BuildManagerCommand;
use CouponURLs\Original\Commands\BuiltIn\CommandCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\CreatorCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\DatabaseManagerCommand;
use CouponURLs\Original\Commands\BuiltIn\HandlerCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\ModelCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\TestCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\TaskCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\ValidatorCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\RendererCreatorCommand;
use CouponURLs\Original\Commands\BuiltIn\TestCommand;
use CouponURLs\Original\Commands\BuiltIn\DomainTestCommandCommand;
use CouponURLs\Original\Commands\BuiltIn\TestFilesCommandCommand;
use CouponURLs\Original\Commands\BuiltIn\DependencyCreatorCommandCommand;
use CouponURLs\Original\Commands\BuiltIn\SubscriberCreatorCommandCommand;

return [
    ModelCreatorCommand::class,
    CreatorCreatorCommand::class,
    HandlerCreatorCommand::class,
    CommandCreatorCommand::class,
    DatabaseManagerCommand::class,
    BuildManagerCommand::class,
    TestCreatorCommand::class,
    TaskCreatorCommand::class,
    ValidatorCreatorCommand::class,
    RendererCreatorCommand::class,
    DomainTestCommandCommand::class,
    TestFilesCommandCommand::class,
    DependencyCreatorCommandCommand::class,
    SubscriberCreatorCommandCommand::class,
];