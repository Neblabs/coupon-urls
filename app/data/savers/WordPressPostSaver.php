<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Data\Savers\Abilities\Saveable;
use CouponURLs\App\Domain\Posts\Post;

abstract class WordPressPostSaver implements Saveable
{
    protected Post $post;

    public function setPost(Post $post) : void
    {
        $this->post = $post;
    }
}