<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Characters\StringManager;

interface DashboardExportable extends Exportable
{
    public function key() : string; 
    public function export() : array|StringManager|string|bool|int|float;
}