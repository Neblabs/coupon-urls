<?php

namespace CouponURLs\Original\Creators\CreatorCreators\ProjectFileCreator;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Creators;

Class ProjectFileCreatorCreators extends Creators
{
    public function __construct(string $creatorName, string $creatorRelativeDirectory)
    {
        $this->creatorName = $creatorName;
        $this->creatorRelativeDirectory = $creatorRelativeDirectory;
    }

    protected function getCreators() : Collection
    {
        return new Collection([
            new ProjectFileCreatorCreator($this->creatorName, $this->creatorDirectory)
        ]);
    }
}