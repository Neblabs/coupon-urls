<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class CategorizedByItsOwnTypeExporter implements ComponentExportable
{
    public function __construct(
        protected ComponentExportable $exporter
    ) {}
    
    /** @param Identifiable $component */
    public function export(mixed $component): Collection
    {
        return _([
            $component->identifier() => $this->exporter->export($component)
        ]);
    } 
}