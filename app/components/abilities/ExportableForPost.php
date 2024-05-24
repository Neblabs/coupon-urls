<?php

namespace CouponURLs\App\Components\Abilities;

use WP_Post;

interface ExportableForPost
{
    public function export(WP_Post $post) : mixed; 
}