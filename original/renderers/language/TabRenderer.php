<?php

namespace CouponURLs\Original\Renderers\Language;

use CouponURLs\Original\Renderers\RendererDecorator;

Class TabRenderer extends RendererDecorator
{
    public function render() : string
    {
        return "    {$this->renderer->render()}";
    }
}