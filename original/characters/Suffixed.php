<?php

namespace CouponURLs\Original\Characters;

use function CouponURLs\Original\Utilities\Text\i;

class Suffixed
{
    protected StringManager $sufixed;

    public function __construct(
        protected string|StringManager $text,
        protected string|StringManager $suffix
    ) {
        $this->text = i($text);
        $this->sufixed = $this->text->ensureRight($suffix);
    }
 
    public function withSuffix() : StringManager
    {
        return $this->sufixed;
    }

    public function withoutSuffix() : StringManager
    {
        return $this->text;
    }
}