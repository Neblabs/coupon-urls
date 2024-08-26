<?php

use CouponURLs\Original\Autoloading\Autoloader;
use CouponURLs\Original\Environment\Env;


require 'original/utilities/facades.php';
require 'original/utilities/collection/collection.php';
require 'original/utilities/text/text.php';
require 'original/utilities/callables/callables.php';
require 'original/utilities/filters/filters.php';
require 'original/environment/env.php';

Env::set(__FILE__);

Env::settings()->environment !== 'production' && require 'original/utilities/text/translation.php';

require Env::directory().'original/autoloading/autoloader.php';
require Env::directory().'vendor/autoload.php';

Autoloader::register();