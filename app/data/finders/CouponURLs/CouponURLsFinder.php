<?php

namespace CouponURLs\App\Data\Finders\Couponurls;

use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Data\Model\Finder;
use CouponURLs\Original\Data\Query\SQLParameters;
use CouponURLs\Original\Environment\Env;
use NilPortugues\Sql\QueryBuilder\Manipulation\Select;
use NilPortugues\Sql\QueryBuilder\Syntax\Where;
use wpdb;

use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class CouponURLsFinder extends Finder
{
    //todo:
    //test that when given /path/to/   works despite the / on boths sides
    public function matchingURI(URI $URI) : self
    {
        $this->parameters->appendSQL(
            i("
                WHERE post_id IN (
                    SELECT post_id FROM :table
                    WHERE meta_key = :URIKEY and meta_value = :URIVALUE
                ) AND meta_key = :queryKey
                ORDER BY meta_value DESC
            ")->replace(':table', $this->parameters->structure()->name())->get(),
            [
                ':URIKEY' => Env::getWithPrefix('uri'),
                ':URIVALUE' => "{$URI->type()}|".i($URI->value())->trim()->trim('/'), // eg: path|/shop/coupons/57634/,
                ':queryKey' => Env::getWithPrefix('query')
            ]
        );

        return $this;
    }
}