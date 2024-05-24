<?php

namespace CouponURLs\Original\Renderers\Language;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Renderers\RendererDecorator;

Class NewLineRenderer extends RendererDecorator
{
    private $direction = 'bottom';

    public function setLineDirection(string $direction)
    {
        $this->direction = $direction;
    }
    
    public function render() : string
    {
        (string) $rendered = $this->renderer->render();

        if (!$rendered) {
            return '';
        }
        
        (object) $newLines = $this->getNewLines();

        return "{$newLines->get('top')}{$rendered}{$newLines->get('bottom')}";
    }

    protected function getNewLines() : Collection
    {
        return new Collection([
            $this->direction => "\n"
        ]);
    }
}