<?php

namespace CouponURLs\App\Components\Options;

use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\__;

class CouponOptionsComponent implements HasInlineOptions
{
    public function options(): Collection
    {
        return _(
            isEnabled: Types::BOOLEAN()->withDefault(false)
        );
    } 
}
