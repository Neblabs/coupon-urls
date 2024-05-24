<?php

namespace CouponURLs\App\Creation;

use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\App\Components\Options\CouponOptionsComponent;
use CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\JSONMapper;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Environment\Env;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;

class OptionsFromTemplateAndOptionableFactory
{
    public function create(?string $template, HasInlineOptions $optionsGetter): MappedObject
    {
        (object) $jsonMapper = new JSONMapper($optionsGetter->options());

        return $jsonMapper->map($template);
    } 
}