<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class ComponentExporterComposite implements ComponentExportable
{
    public function __construct(
        protected Collection/*<ComponentExportable>*/ $componentExportables
    ) {}
    
    public function export(mixed $componentToExport): Collection
    {
        (array) $component = [];

        foreach ($this->componentExportables->asArray() as $exportable) {
            $component = [
                ...$component,
                ...$exportable->export($componentToExport)
            ];
        }

        return _($component);
    } 
}