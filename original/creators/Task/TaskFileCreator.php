<?php

namespace CouponURLs\Original\Creators\Task;

use CouponURLs\Original\Creators\ClassFileCreator;
use CouponURLs\Original\Creators\TemplateProjectFileCreator;

Class TaskFileCreator extends ClassFileCreator
{
    public function __construct(string $taskName, string $relativeDirectory)
    {
        $this->taskName = ucfirst("{$taskName}Task");

        $this->relativeDirectory = $relativeDirectory;
    }
    
    protected function getClassName() : string
    {
        return $this->taskName;
    }

    protected function getRelativeDirectory() : string
    {
        return $this->relativeDirectory;
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/TaskTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [];
    }
}