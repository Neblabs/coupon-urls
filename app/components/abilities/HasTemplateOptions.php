<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\App\Domain\Templates\Abilities\TemplateDefinition;

interface HasTemplateOptions
{
    public function options() : TemplateDefinition; 
}