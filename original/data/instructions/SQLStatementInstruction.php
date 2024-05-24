<?php

namespace CouponURLs\Original\Data\Instructions;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;

Class SQLStatementInstruction extends Instruction
{
    public function __construct(string $statement, array $parameters = [])
    {
        $this->statement = new StringManager($statement);
        $this->parameters = new Collection($parameters);
    }

    public function shouldGet() : bool
    {
        return $this->is('select|describe');
    }

    protected function is(string $statementToCheck) : bool
    {
        (string) $statementType = $this->statement->explode(' ')->first();

        return in_array(strtolower($statementType), explode('|', $statementToCheck));
    }
}