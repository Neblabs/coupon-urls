<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Data\Savers\Abilities\KeyValueSaveableDataProvider;
use CouponURLs\App\Domain\Posts\Post;

abstract class WordPressPostMetaSaverDataProvider implements KeyValueSaveableDataProvider
{
    protected Post $post;

    public function setPost(Post $post) 
    {
        $this->post = $post;
    }
}