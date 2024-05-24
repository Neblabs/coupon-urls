<?php

use CouponURLs\App\Data\Schema\ApplicationDatabase;
use CouponURLs\App\Events\CustomGlobalEventsValidator;

use function CouponURLs\Original\Utilities\Collection\o;

return o(
    app: o(
        id: 'coupon_urls',
        shortId: 'cpu',
        namespace: 'CouponURLs',
        pluginFileName: 'coupon-urls',
        textDomain: 'coupon-urls-international',
        translationFiles: o(
            production: 'international/coupon-urls-international.pot',
            main: 'international/main-source.pot',
            scripts: 'international/scripts-source.pot'
        )
    ),
    events: o(
        globalValidator: CustomGlobalEventsValidator::class
    ),
    schema: o(
        applicationDatabase: ApplicationDatabase::class
    ),
    directories: o(
        app: o(
            schema: 'data/schema',
            scripts: 'scripts',
            dashboard: 'scripts/dashboard',
        ),
        storage: o(
            branding: 'storage/branding'
        )
    ),
    environment: 'development',
    tests: o(
        loadPlugins: [
            //a relative path to the plugin relative to the wordpress plugins/ dirrectory in integration
            'woocommerce/woocommerce.php'
        ]
    ),
    binaries: o(
        php: '/opt/local/bin/php',
        phpunit: './vendor/bin/phpunit'
    )
);