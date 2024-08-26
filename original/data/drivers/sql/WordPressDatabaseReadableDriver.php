<?php

namespace CouponURLs\Original\Data\Drivers\SQL;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Drivers\Abilities\SQLReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Data\Query\SQLParameters;
use CouponURLs\Original\System\ObjectWrapper;

use function CouponURLs\Original\Utilities\Collection\{a, _};
use wpdb;

class WordPressDatabaseReadableDriver implements SQLReadableDriver
{
    public function __construct(
        /**
         * This one is a wrapper for unit testing (mocking)
         */
        protected ObjectWrapper $wordpressDatabaseWrapper
    ) {}

    /** @param SQLParameters $parameters */
    public function findMany(Parameters $parameters): Collection
    {
        return _($this->wordpressDatabaseWrapper->call(
            'get_results', 
            $this->wordpressDatabaseWrapper->call(
                'prepare', 
                $this->getQueryStringReplacedWithPrintfPlaceholders($parameters),
                $parameters->queryValues()->asArray()
            ),
            ARRAY_A
        ));            
    } 

    /** @param SQLParameters $parameters */
    public function findOne(Parameters $parameters): array|null
    {
        return $this->wordpressDatabaseWrapper->call(
            'get_row', 
            $this->wordpressDatabaseWrapper->call(
                'prepare', 
                $this->getQueryStringReplacedWithPrintfPlaceholders($parameters),
                $parameters->queryValues()->asArray()
            ), 
            ARRAY_A
        );  
    } 

    // we'll optimize this in the future, for now it should work just fine...
    public function has(Parameters $parameters): bool
    {
        return (boolean) $this->findOne($parameters);
    } 

    // we'll optimize this in the future, for now it should work just fine...
    public function count(Parameters $parameters): int
    {
        return $this->findMany($parameters)->count();
    } 

    /** @param SQLParameters $parameters */
    protected function getQueryStringReplacedWithPrintfPlaceholders(Parameters $parameters) : string
    {
        (object) $query = $parameters->queryString();

        (string) $float = '%f';
        (string) $integer = '%d';
        (string) $string = '%s';

        foreach($parameters->queryValues() as $key => $value) {
            /*mixed*/ $replacement = match(is_numeric($value)) {
                true => str_contains($value, needle: '.')? $float : $integer,
                false => $string
            };

            $query = $query->replace(
                $key, 
                $replacement
            );
        }

        return $query->get();
    }
}