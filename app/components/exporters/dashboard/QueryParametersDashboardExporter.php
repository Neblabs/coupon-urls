<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Environment\Env;
use WP_Post;

use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class QueryParametersDashboardExporter implements DashboardExportableForPost
{
    public function __construct(
        protected QueryParametersFromStringFactory $queryParametersFromStringFactory
    ) {}
    
    public function key(): string
    {
        return 'queryParameters';
    } 

    public function export(WP_Post $post): array
    {
        return $this->queryParametersFromStringFactory->create(
            get_post_meta(
                post_id: $post->ID,
                key: Env::getWithPrefix('query'),
                single: true
            ) ?: ''
        )->all()->map(fn(mixed $value, string $key) => a(key: $key, value: $value))->getValues()->asArray();
    } 
}