<?php

namespace CouponURLs\Original\Utilities\Text;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Environment\Env;

function i(string|StringManager|null $string) : StringManager {
    return $string instanceof StringManager
           ? $string
           : new StringManager($string ?? '');
}