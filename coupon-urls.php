<?php

use CouponURLs\App\Creation\Environment\EnvironmentFactory;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\GettableCollectionDecorator;
use CouponURLs\Original\Construction\Abilities\HandleableServiceExceptionFactory;
use CouponURLs\Original\Construction\Core\DevelopmentServiceExceptionHandlerFactory;
use CouponURLs\Original\Construction\Core\ProductionServiceExceptionHandlerFactory;
use CouponURLs\Original\Construction\Dependency\ProductionDependenciesContainerFactory;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Core\Application;
use CouponURLs\Original\Core\Services\ActionsService;
use CouponURLs\Original\Core\Services\DependenciesService;
use CouponURLs\Original\Core\Services\MonitorService;
use CouponURLs\Original\Dependency\Framework\AppDependencyTypes;
use CouponURLs\Original\Dependency\Framework\OriginalDependencyTypes;
use CouponURLs\Original\Dependency\Framework\ValidDependencyTypes;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Files\RequireFileReader;

use function CouponURLs\Original\Utilities\Collection\_a;

/*
Plugin Name: Coupon URLs for WooCommerce - Extension
Plugin URI:  
Description: Add a coupon and optionally a product when clicking a custom URL.
Version:      1.1.4
Author:       Neblabs
Author URI:   https://neblabs.com
Text Domain:  coupon-urls-international
Domain Path:  /international
Requires at least: 4.7
Requires PHP: 7.2
*/

require_once 'bootstrap.php';

(object) $environmentFactory = new EnvironmentFactory;
(object) $environment = $environmentFactory->create(Env::settings()->environment);

(object) $overloadableServiceExceptionFactories = new FactoryOverloader(_a([
    new DevelopmentServiceExceptionHandlerFactory,
    new ProductionServiceExceptionHandlerFactory,
]));

/** @var HandleableServiceExceptionFactory */
(object) $serviceExceptionFactory = $overloadableServiceExceptionFactories->overload($environment);

(object) $application = new Application(
    $serviceExceptionFactory->create()
);

$application->addService(
    new DependenciesService(
        new ProductionDependenciesContainerFactory,
        new ValidDependencyTypes(
            new GettableCollectionDecorator(
                new ByFileGettableCollection(
                    new OriginalDependencyTypes,
                    new RequireFileReader(
                        new MemoryCache
                    )
                ),
                new ByFileGettableCollection(
                    new AppDependencyTypes,
                    new RequireFileReader(
                        new MemoryCache
                    )
                )
            )
        )
    )  
);
$application->addService(new MonitorService);
$application->addService(new ActionsService);

add_action('wp_loaded', function() use ($application) {
    if (class_exists(WooCommerce::class)) {
        $application->start();
    }
}, 5);
