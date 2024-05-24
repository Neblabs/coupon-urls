<?php

namespace CouponURLs\App\Domain\Uris;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;

class QueryParameters
{
    public function __construct(
        protected Collection $parameters
    ) {
        $this->parameters = $parameters->map(
            fn(mixed $value) => $value instanceof StringManager? $value->get() : $value
        );
    }
    
    public function get(string $key) : mixed
    {
        return $this->parameters->get($key);
    }

    public function has(string $key) : bool
    {
        return $this->parameters->have($key);
    }

    public function all() : Collection
    {
        return clone $this->parameters;
    }

    /**
     * $queryParameters should have ALL parameters
     * $this CAN have more and still match, as long as it has 
     * all of $queryParameters
     */
    public function hasAllOf(QueryParameters $queryParameters) : bool
    {
        return $queryParameters->parameters->doesNotHave(
            fn(mixed $value, string $key) => $this->get($key) !== $value
        );
    }
}