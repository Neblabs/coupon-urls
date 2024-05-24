<?php

namespace CouponURLs\Original\Renderers\Language;

use CouponURLs\Original\Renderers\RendererDecorator;

Class NativeTypedVariableRenderer extends RendererDecorator
{
    private $type;

    public function setType(string $type)
    {
        $this->type = $type;
    }
    
    public function render() : string
    {
        return "{$this->type} {$this->renderer->render()}";
    }
}