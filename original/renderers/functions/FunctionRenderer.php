<?php

namespace CouponURLs\Original\Renderers\Functions;

use CouponURLs\Original\Renderers\Abilities\Renderable;
use CouponURLs\Original\Renderers\Functions\FunctionArgumentsRenderer;
use CouponURLs\Original\Renderers\Functions\FunctionReturnTypeRenderer;
use CouponURLs\Original\System\Compositable;

Class FunctionRenderer implements Renderable
{
    private $name;
    private $functionArgumentsRenderer;
    private $functionReturnTypeRenderer;
    private $functionBodyRenderer;

    public function __construct()
    {
        $this->name = '';
        $this->functionArgumentsRenderer = new Compositable([]);
        $this->functionReturnTypeRenderer = new Compositable([]);
        $this->functionBodyRenderer = new Compositable([]);
    }

    public function setName(string $name)
    {
        $this->name = $name;   
    }
    
    public function setReturnTypeRenderer(FunctionReturnTypeRenderer $functionReturnTypeRenderer)
    {
        $this->functionReturnTypeRenderer = $functionReturnTypeRenderer;
    }

    public function setArgumentsRenderer(FunctionArgumentsRenderer $functionArgumentsRenderer)
    {
        $this->functionArgumentsRenderer = $functionArgumentsRenderer;
    }

    public function setBodyRenderer(Renderable $functionBodyRenderer)
    {
        $this->functionBodyRenderer = $functionBodyRenderer;
    }
    
    public function render() : string
    {
        return 
    "function{$this->renderName()}({$this->functionArgumentsRenderer->render()}) {$this->functionReturnTypeRenderer->render()}
    {
        {$this->functionBodyRenderer->render()}
    }";
    }

    protected function renderName() : string
    {
        if ($this->name) {
            return " {$this->name}";   
        }
        // notice the space at the beginning
        return '';
    }
    
}