<?php

namespace CouponURLs\Original\Renderers;

use CouponURLs\Original\Renderers\Abilities\Renderable;

Abstract Class RendererDecorator implements Renderable
{
    protected $renderer;

    public function __construct(Renderable $renderer)
    {
        $this->renderer = $renderer;
    }
}