<?php

namespace CouponURLs\Original\Data\Instructions\Options;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Instructions\Instruction;

Class GetWordPressOptionsAPIInstruction extends Instruction
{
    protected $statement = 'GET';

    public function __construct(string $name, /*mixed*/ $default)
    {
        $this->parameters = new Collection([
            'name' => $name,
            'default' => $default
        ]);
    }
}