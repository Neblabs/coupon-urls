<?php
use CouponURLs\App\Dependencies\CouponsToBeAddedDependency;
use CouponURLs\App\Dependencies\DiscountsDependency;
use CouponURLs\App\Dependencies\CartDependency;
use CouponURLs\App\Dependencies\ActionsDependency;
use CouponURLs\App\Dependencies\URIDependency;
use CouponURLs\App\Dependencies\ActionComponentsDependency;
use CouponURLs\App\Dependencies\CouponURLsFinderDependency;
use CouponURLs\App\Dependencies\wpdbDependency;
use CouponURLs\App\Dependencies\ActionsFactoryDependency;
use CouponURLs\App\Dependencies\OptionsFactoryDependency;
use CouponURLs\App\Dependencies\DashboardDataDependency;

return [
    // here the magic will happen!,
    CouponsToBeAddedDependency::class,
    DiscountsDependency::class,
    CartDependency::class,
    ActionsDependency::class,
    URIDependency::class,
    ActionComponentsDependency::class,
    CouponURLsFinderDependency::class,
    wpdbDependency::class,
    ActionsFactoryDependency::class,
    OptionsFactoryDependency::class,
    DashboardDataDependency::class,
];