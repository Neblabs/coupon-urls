<?php

namespace CouponURLs\App\Data\Finders\Couponurls;

use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Data\Model\Finder;
use CouponURLs\Original\Environment\Env;

use function CouponURLs\Original\Utilities\Text\i;

class CouponURLsFinder extends Finder
{
    //todo:
    //test that when given /path/to/   works despite the / on boths sides
    public function matchingURI(URI $URI) : self
    {
        global $wpdb;

        $this->parameters->appendSQL(
            i("
                WHERE post_id IN (
                    SELECT ID FROM :postsTable
                    WHERE post_status = 'publish'
                    AND post_id IN (
                        SELECT post_id FROM :table
                        WHERE meta_key = :URIKEY and meta_value = :URIVALUE
                    )
                ) AND meta_key = :queryKey
                ORDER BY meta_value DESC
            ")->replace(':table', $this->parameters->structure()->name())
              ->replace(':postsTable', sanitize_text_field($wpdb->posts))
              ->get(),
            [
                ':URIKEY' => Env::getWithPrefix('uri'),
                ':URIVALUE' => "{$URI->type()}|".i($URI->value())->trim()->trim('/'), // eg: path|/shop/coupons/57634/,
                ':queryKey' => Env::getWithPrefix('query'),
            ]
        );

        return $this;
    }
}