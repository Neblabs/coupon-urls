<?php

namespace CouponURLs\Original\Renderers\Comments;

use CouponURLs\Original\Renderers\Language\NewLineRenderer;
use CouponURLs\Original\Renderers\Language\TextRenderer;
use CouponURLs\Original\Renderers\RendererDecorator;

Class DocCommentLineRenderer extends RendererDecorator
{
    public function render() : string
    {
        return "* {$this->renderer->render()}";
    }
}