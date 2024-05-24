<?php

namespace CouponURLs\Original\Data\Drivers\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;

class WordPressPostArrayReadableDriver implements ReadableDriver
{
    public function __construct(
        protected WordPressPostReadableDriver $wordPressPostReadableDriver
    ) {}
    
    public function findOne(Parameters $parameters): mixed
    {
        (object) $WP_Post = $this->wordPressPostReadableDriver->findOne($parameters);

        return $WP_Post->to_array();
    } 

    public function findMany(Parameters $parameters): Collection
    {
        return $this->wordPressPostReadableDriver->findMany($parameters)->mapUsing(to_array: null);
    } 

    public function has(Parameters $parameters): bool
    {
        return $this->wordPressPostReadableDriver->has($parameters);
    } 

    public function count(Parameters $parameters): int
    {
        return $this->wordPressPostReadableDriver->count($parameters);       
    } 
}