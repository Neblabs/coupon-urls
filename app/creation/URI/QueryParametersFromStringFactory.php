<?php

namespace CouponURLs\App\Creation\Uri;

use CouponURLs\App\Domain\Uris\QueryParameters;
use CouponURLs\Original\Characters\StringManager;

use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class QueryParametersFromStringFactory
{
    public function create(string $query): QueryParameters
    {
        return new QueryParameters(
            i($query)->removeLeft('?')->explode('&')->mapWithKeys(
                fn(StringManager $keyAndValue) => a(
                    key: (string) $keyAndValue->explode('=')->first()->toLowerCase(),
                    value: (string) $keyAndValue->contains('=')? $keyAndValue->explode('=')->last()->toLowerCase() : ''
                )
            )
        );
    } 
}