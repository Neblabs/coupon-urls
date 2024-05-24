<?php

namespace CouponURLs\Original\Creators\Renderer;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Creators\ClassFileCreator;
use CouponURLs\Original\Environment\Env;

Class RendererFileCreator extends ClassFileCreator
{
    private $rendererName;
    private $relativeDirectory;
    private $isDecorator;

    public function __construct(string $rendererName, string $relativeDirectory, bool $isDecorator)
    {
        $this->rendererName = StringManager::create($rendererName)->ensureRight('Renderer')->uppercaseFirst();   
        $this->relativeDirectory = $relativeDirectory;
        $this->isDecorator = $isDecorator;
    }
    
    protected function getClassName() : string
    {
        return $this->rendererName;
    }

    protected function getBaseClassName() : string 
    { 
        return $this->isDecorator? 'RendererDecorator' : ''; 
    }

    protected function getBaseClassNamespace() : string 
    { 
        return $this->isDecorator? Env::getWithBaseNamespace('Original\Renderers') : '';
    }

    protected function getRelativeDirectory() : string
    {
        return $this->relativeDirectory;
    }

    protected function getTemplatePath() : string
    {
        if ($this->isDecorator) {
            return dirname(__FILE__).'/RendererDecoratorTemplate.php';
        }

        return dirname(__FILE__).'/RendererTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [
        ];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $customData = [
        ];

        return array_merge(parent::getDataToPassToTasks(), $customData, $this->getTemplateVariables());
    }
}