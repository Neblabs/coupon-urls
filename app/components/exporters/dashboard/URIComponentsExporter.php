<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Components;
use CouponURLs\App\Components\Exporters\ComponentExporterComposite;
use CouponURLs\App\Components\Exporters\DescriptableExporter;
use CouponURLs\App\Components\Exporters\IdentifiableExporter;
use CouponURLs\App\Components\Exporters\InlineOptionsMapExporter;
use CouponURLs\App\Components\Exporters\NameableExporter;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class URIComponentsExporter implements DashboardExportable
{
    public function key(): string
    {
        return 'uris';
    } 

    public function export() : array
    {
        return [
            a(
                id: 'homepage',
                name: 'Homepage',
                description: get_option('siteurl')
            ),
            a(
                id: 'path',
                name: 'Custom Path',
                description: 'Example: /CODE'
            )
        ];
    } 
}