<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Formable;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\Original\Collections\Collection;

use function CouponURLs\Original\Utilities\Collection\_;

class FormableExporter implements ComponentExportable
{
    /** @param Formable $component */
    public function export(mixed $component): Collection
    {
        return _(
            form: (string) $component->form()->identifier()
        );
    } 
}