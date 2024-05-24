<?php

namespace CouponURLs\Original\Data\Model\Finders\Wordpress;

use CouponURLs\App\Domain\Posts\Post;
use CouponURLs\Original\Data\Model\Abilities\Identifiable;
use CouponURLs\Original\Data\Model\Finder;

class WordPressPostMetaFinder extends Finder
{
    public function belongingToPost(Identifiable $post) : self
    {
        //$this->parameters->add(name: 'postId', value: $post->id());

        return $this;
    }

    public function withKey(string $key) :self
    {
        //$this->parameters->add(name: 'key', value: $key);

        return $this;
    }
}