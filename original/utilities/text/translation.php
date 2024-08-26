<?php

namespace CouponURLs\Original\Utilities\Text;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Environment\Env;

use function CouponURLs\Original\Utilities\Text\i;

function __(string $translatableText) : StringManager {
    return i(\__($translatableText, domain: Env::textDomain()));
}