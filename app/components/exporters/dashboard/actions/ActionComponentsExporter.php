<?php

namespace CouponURLs\App\Components\Exporters\Dashboard\Actions;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Components;
use CouponURLs\App\Components\Exporters\ComponentExporterComposite;
use CouponURLs\App\Components\Exporters\DescriptableExporter;
use CouponURLs\App\Components\Exporters\DescriptablesExporter;
use CouponURLs\App\Components\Exporters\IdentifiableExporter;
use CouponURLs\App\Components\Exporters\InlineOptionsMapExporter;
use CouponURLs\App\Components\Exporters\NameableExporter;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class ActionComponentsExporter implements DashboardExportable
{
    public function __construct(
        protected Components $actionComponents
    ) {}
    
    public function key(): string
    {
        return 'actions';
    } 

    public function export() : array
    {
        (object) $exporter = new ComponentExporterComposite(_(
            new IdentifiableExporter,
            new NameableExporter,
            new DescriptablesExporter,
            new InlineOptionsMapExporter
        ));

        return $this->actionComponents->all()->map(
            $exporter->export(...)
        )->asArray();
    } 
}