<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Descriptable;
use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class InlineOptionsMapExporter implements ComponentExportable
{
    /** @param HasInlineOptions $component */
    public function export(mixed $component): Collection
    {
        return _(
            options: $component instanceof HasInlineOptions? $component->options() : a(__: null)
        );
    } 
}