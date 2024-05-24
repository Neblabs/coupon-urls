<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\App\Components\Abilities\SingularNameable;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;

class SingularNameableExporter implements ComponentExportable
{
    /** @param SingularNameable $component */
    public function export(mixed $component): Collection
    {
        return _(
            nameSingular: (string) $component->nameSingular()
        );
    } 
}