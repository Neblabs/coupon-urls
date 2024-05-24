<?php

namespace CouponURLs\Original\Creators\CreatorCreators\ProjectFileCreator;

use CouponURLs\Original\Creators\TemplateProjectFileCreator;
use CouponURLs\Original\Environment\Env;

Class ProjectFileCreatorCreator extends TemplateProjectFileCreator
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
        return dirname(__FILE__).'/creatorTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [
            'namespace' => Env::getNamespaceFromDirectory($this->getRelativeDirectory()),
            'className' => $this->getClassName(),
            'entityName' => $this->creatorName
        ];
    }

    protected function getFileName() : string
    {
        return "{$this->getClassName()}.php";
    }

    protected function getClassName() : string
    {
        return "{$this->creatorName}FileCreator";   
    }
    
    protected function getRelativeDirectory() : string
    {
        return "original/creators/{$this->creatorRelativeDirectory}";
    }
}