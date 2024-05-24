<?php

namespace CouponURLs\Original\Creators\CreatorCreators\TemplateProjectFileCreator;

use CouponURLs\Original\Creators\TemplateProjectFileCreator;

Class TemplateFileCreator extends TemplateProjectFileCreator
{
    protected $creatorName;
    protected $creatorRelativeDirectory;

    public function __construct(string $creatorName, string $creatorRelativeDirectory)
    {
        $this->creatorName = ucfirst($creatorName);
        $this->creatorRelativeDirectory = $creatorRelativeDirectory;
    }
    
    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/templateTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [];
    }

    protected function getFileName() : string
    {
        return "{$this->creatorName}Template.php";
    }

    protected function getRelativeDirectory() : string
    {
        return $this->creatorRelativeDirectory;
    }
}