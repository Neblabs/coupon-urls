<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class NameableExporter implements ComponentExportable
{
    /** @param Nameable $component */
    public function export(mixed $component): Collection
    {
        return _(
            name: $component instanceof Nameable? (string) $component->name() : ''
        );
    } 
}