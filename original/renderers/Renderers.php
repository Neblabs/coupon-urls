<?php

namespace CouponURLs\Original\Renderers\Classes;

use CouponURLs\Original\Collections\TypedCollection;
use CouponURLs\Original\Renderers\Abilities\Renderable;
use CouponURLs\Original\System\Compositable;

Class Renderers implements Renderable
{
    private $renderersComposite;

    public function __construct(iterable $renderers)
    {
        $this->renderersComposite = new Compositable($renderers);
    }

    public function render()
    {
        $this->renderersComposite->render();
    }
}