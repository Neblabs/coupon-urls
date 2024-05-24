<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;

interface ComponentExportable
{
    public function export(mixed $component) : Collection;
}