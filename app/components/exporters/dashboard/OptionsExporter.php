<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\Original\Environment\Env;
use WP_Post;

use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class OptionsExporter implements DashboardExportableForPost
{
    public function key(): string
    {
        return 'options';
    } 

    public function export(WP_Post $post): array
    {
        (object) $options = json_decode((get_post_meta(
                        post_id: $post->ID,
                        key: Env::getWithPrefix('options'),
                        single: true
                    ) ?: '{"isEnabled": false}'));

        return a(
            isEnabled: $options->isEnabled
        );
    } 
}