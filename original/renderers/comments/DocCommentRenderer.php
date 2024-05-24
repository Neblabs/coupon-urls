<?php

namespace CouponURLs\Original\Renderers\Comments;

use CouponURLs\Original\Renderers\RendererDecorator;

Class DocCommentRenderer extends RendererDecorator
{
    public function render() : string
    {
        return 
"/**
 {$this->renderer->render()}
 */";
    }
}