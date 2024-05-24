<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Characters\StringManager;
use WP_Post;

interface DashboardExportableForPost extends ExportableForPost
{
    public function key() : string; 
    public function export(WP_Post $post) : array|StringManager|string|bool|int|float;
}