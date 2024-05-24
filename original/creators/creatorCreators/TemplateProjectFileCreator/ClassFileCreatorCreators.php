<?php

namespace CouponURLs\Original\Creators\CreatorCreators\TemplateProjectFileCreator;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\CreatorCreators\TemplateProjectFileCreator\ClassFileCreatorCreator;
use CouponURLs\Original\Creators\Creators;
use CouponURLs\Original\Creators\OriginalCreators\CreatorCreators\ProjectFileCreator\ProjectFileCreatorCreator;
use CouponURLs\Original\Creators\Task\TaskFileCreator;

Class ClassFileCreatorCreators extends Creators
{
    public function __construct(string $creatorName, string $creatorRelativeDirectory)
    {
        $this->creatorName = $creatorName;
        $this->creatorRelativeDirectory = $creatorRelativeDirectory;
    }

    protected function getCreators() : Collection
    {
        return new Collection([
            new ClassFileCreatorCreator($this->creatorName, $this->creatorRelativeDirectory),
            new TemplateFileCreator($this->creatorName, $this->creatorRelativeDirectory),
            new TaskFileCreator($this->creatorName, $this->creatorRelativeDirectory)
        ]);
    }
}