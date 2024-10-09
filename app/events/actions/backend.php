<?php

use function CouponURLs\Original\Utilities\Collection\a;

return a(
    admin_enqueue_scripts: [
        'CouponURLs\\App\\Subscribers\\DashboardScriptsRegistrator',
    ],
    wp_loaded: [
        'CouponURLs\\App\\Subscribers\\PostTypeSearchTitleFilter',
    ],
    save_post: [
        'CouponURLs\\App\\Subscribers\\CouponURLsDataSaver',
    ],
    admin_init: [
        'CouponURLs\\App\\Subscribers\\PluginScreenActionButtonsRegistrator',
    ],
);