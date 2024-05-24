<?php

namespace CouponURLs\Original\Renderers\Language;

use CouponURLs\Original\Renderers\Abilities\Renderable;

Class TextRenderer implements Renderable
{
    private $text;

    public function __construct(string $text = '')
    {
        $this->text = $text;
    }
    
    public function render() : string
    {
        return $this->text;
    }
}
