<?php

namespace CouponURLs\Original\Data\Instructions\Options;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Instructions\Instruction;
use WTEApp\Data\Model\Options\Option;

Class UpdateWordPressOptionsAPIInstruction extends Instruction
{
    protected $statement = 'UPDATE';

    public function __construct(Option $option)
    {
        $this->parameters = new Collection([
            'name' => $option->option_name,
            'value' => $option->option_value,
        ]);
    }

    public function shouldGet() : bool
    {
        return false;
    }
}