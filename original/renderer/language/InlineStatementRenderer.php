<?php

namespace CouponURLs\Original\Renderer\Language;

use CouponURLs\Original\Renderers\RendererDecorator;

Class InlineStatementRenderer extends RendererDecorator
{
    public function render() : string
    {
        return "{$this->renderer->render()};";
    }
}