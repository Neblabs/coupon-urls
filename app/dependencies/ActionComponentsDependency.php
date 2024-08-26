<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Components\Actions\Builtin\AddCouponComponent;
use CouponURLs\App\Components\Actions\Builtin\AddProductComponent;
use CouponURLs\App\Components\Actions\Builtin\CouponAddedToCartExtraNotificationMessageComponent;
use CouponURLs\App\Components\Actions\Builtin\CouponToBeAddedNotificationMessageComponent;
use CouponURLs\App\Components\Actions\Builtin\RedirectionComponent;
use CouponURLs\App\Components\Components;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\Context;

use function CouponURLs\Original\Utilities\Collection\_;

class ActionComponentsDependency implements Cached, StaticType, Dependency
{
    static public function type(): string
    {
        return Components::class;
    } 

    public function canBeCreated(Context $context): bool
    {
        return $context->nameIs('actionComponents');    
    } 

    public function create(): Components
    {
        return new Components(_(
            new AddCouponComponent,
            new CouponToBeAddedNotificationMessageComponent,
            new AddProductComponent,
            new CouponAddedToCartExtraNotificationMessageComponent,
            new RedirectionComponent
        ));
    } 
}