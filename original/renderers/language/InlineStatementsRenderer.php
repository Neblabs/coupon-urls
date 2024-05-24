<?php

namespace CouponURLs\Original\Renderers\Language;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Renderer\Language\InlineStatementRenderer;
use CouponURLs\Original\Renderers\Abilities\Renderable;
use CouponURLs\Original\Renderers\Language\NewLineRenderer;

Class InlineStatementsRenderer implements Renderable
{
    public function __construct(iterable $renderers)
    {
        $this->renderers = Collection::create($renderers)->map(function(Renderable $renderable) : InlineStatementRenderer {
            return new InlineStatementRenderer($renderable);
        });
    }
    
    public function render() : string
    {
        return $this->renderers->map(function(InlineStatementRenderer $inlineStatementRenderer) : string {
            return (new NewLineRenderer($inlineStatementRenderer))->render();
        })->implode()->trim("\n");
    }
}
