<?php

namespace CouponURLs\Original\Renderers\Functions;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Renderers\Abilities\Renderable;

Class FunctionArgumentsRenderer implements Renderable
{
    private $argumentRenderersCollection;

    public function __construct(iterable $argumentRenderers)
    {
        $this->argumentRenderersCollection = new Collection($argumentRenderers);
    }
    
    public function render() : string
    {
        return $this->argumentRenderersCollection->map(function(Renderable $renderable) : string {
            return $renderable->render();
        })->asList();
    }
}
