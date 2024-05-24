<?php

namespace CouponURLs\Original\Creators\CreatorCreators\TemplateProjectFileCreator;

use CouponURLs\Original\Creators\ClassFileCreator;
use CouponURLs\Original\Environment\Env;

Class ClassFileCreatorCreator extends ClassFileCreator
{
    protected $creatorName;
    protected $creatorRelativeDirectory;

    public function __construct(string $creatorName, string $creatorRelativeDirectory)
    {
        $this->creatorName = ucfirst($creatorName);
        $this->creatorRelativeDirectory = $creatorRelativeDirectory;
    }

    protected function getClassName() : string
    {
        return "{$this->creatorName}FileCreator";   
    }
    
    protected function getRelativeDirectory() : string
    {
        return $this->creatorRelativeDirectory;
    }
    
    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/classFileCreatorTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [
            'entityName' => $this->creatorName,
            'templateName' => "{$this->creatorName}Template.php"
        ];
    }
}