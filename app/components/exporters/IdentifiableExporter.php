<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class IdentifiableExporter implements ComponentExportable
{
    /** @param Identifiable $component */
    public function export(mixed $component): Collection
    {
        return _(
            type: (string) $component->identifier()
        );
    } 
}