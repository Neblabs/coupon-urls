<?php

namespace CouponURLs\App\Data\Schema;

use CouponURLs\Original\Data\Schema\Fields;
use CouponURLs\Original\Data\Schema\Fields\Field;
use CouponURLs\Original\Data\Schema\Fields\ID;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Data\Schema\Structure;

use function CouponURLs\Original\Utilities\Collection\_;

class PostMetaStructure extends Structure
{
    public function name(): string
    {
        global $wpdb;

        return $wpdb->postmeta;
    }  

    public function fields(): Fields
    {
        return new Fields(_(
            new Field(name: 'meta_id', alias: 'id'),
            new Field(name: 'post_id', alias: 'postId'),
            new Field(name: 'meta_key', alias: 'key'),
            new Field(name: 'meta_value', alias: 'value')
        ));
    } 
}