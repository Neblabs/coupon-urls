<?php

namespace CouponURLs\Original\Renderers\Comments;

use CouponURLs\Original\Renderers\Abilities\Renderable;
use CouponURLs\Original\Renderers\RendererDecorator;

Class AnnotationRenderer extends RendererDecorator
{
    public function render() : string
    {
        return "@{$this->renderer->render()}";
    }
}
