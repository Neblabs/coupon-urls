<?php

namespace CouponURLs\Original\Data\Drivers\SQL;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Drivers\Abilities\SQLReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Data\Query\SQLParameters;
use CouponURLs\Original\Data\Query\WordPressSQLParameters;
use CouponURLs\Original\Data\Schema\Structure;
use function CouponURLs\Original\Utilities\Collection\{a, _};
use wpdb;

class WordPressDatabaseReadableDriver implements SQLReadableDriver
{
    public function __construct(
        protected wpdb $wpdb
    ) {}

    /** @param SQLParameters $parameters */
    public function findMany(Parameters $parameters): Collection
    {
        (object) $wpdb = $this->wpdb;

        return _($wpdb->get_results(
            query: ($wpdb->prepare(
                            ($this->getQueryStringReplacedWithPrintfPlaceholders($parameters)),
                            ($parameters->queryValues()->asArray())
                        )), 
            output: ARRAY_A
        ));            
    } 

    /** @param SQLParameters $parameters */
    public function findOne(Parameters $parameters): array|null
    {
        (object) $wpdb = $this->wpdb;

        return $wpdb->get_row(
            query: $wpdb->prepare(
                $this->getQueryStringReplacedWithPrintfPlaceholders($parameters),
                $parameters->queryValues()->asArray()
            ), 
            output: ARRAY_A
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
        (object) $query = ($parameters->queryString());

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