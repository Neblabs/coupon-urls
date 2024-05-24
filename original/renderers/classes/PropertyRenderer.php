<?php

namespace CouponURLs\Original\Renderers\Classes;

Class PropertyRenderer implements Renderable
{
    private $property;

    public function __construct(Property $property)
    {
        $this->property = $property;   
    }
    
    public function render()
    {
        echo "{$this->property->getVisibility()} \${$this->property->getName()}";
    }
}