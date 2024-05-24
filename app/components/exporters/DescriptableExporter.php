<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Descriptable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class DescriptableExporter implements ComponentExportable
{
    /** @param Descriptable $component */
    public function export(mixed $component): Collection
    {
        return _(
            description: $component instanceof Descriptable? (string) $component->description() : ''
        );
    } 
}