<?php

namespace CouponURLs\Original\Dependency\Builtin;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\OnlyValidGroupedGettableCollectionComposite;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Events\Wordpress\Framework\OriginalSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\RegisteredSubscribers;
use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Events\Wordpress\Framework\AppBackendSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\AppBackendSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\AppFrontEndSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\AppFrontEndSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\AppGlobalSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\AppGlobalSubscribersSource;

use function CouponURLs\Original\Utilities\Collection\_;

class RegisteredSubscribersDependency implements Cached, StaticType, Dependency
{
    static public function type(): string
    {
        return RegisteredSubscribers::class;   
    } 

    public function canBeCreated(Context $context): bool
    {
        return true;        
    } 

    public function create(): object
    {
        return new RegisteredSubscribers(_(
            new ByFileGettableCollection(
                new OriginalSubscribers
            ),
            new OnlyValidGroupedGettableCollectionComposite(_(
                new AppGlobalSubscribers(new AppGlobalSubscribersSource),
                new AppBackendSubscribers(new AppBackendSubscribersSource),
                new AppFrontEndSubscribers(new AppFrontEndSubscribersSource)
            ))
        ));       
    } 
}