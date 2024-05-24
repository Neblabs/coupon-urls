<?php

namespace CouponURLs\Original\Creators\Command;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\ClassFileCreator;
use CouponURLs\Original\Environment\Env;

Class CommandFileCreator extends ClassFileCreator
{
    protected $className;
    protected $relativeDirectory;
    protected $templateFile;

    public function __construct(string $commandNameNoSuffix, bool $createInAppDirectory, string $templateFile = null, Collection $dataToPassToTemplate = new Collection([]))
    {
        $this->commandNameNoSuffix = ucfirst($commandNameNoSuffix);
        $this->createInAppDirectory = $createInAppDirectory;
        $this->relativeDirectory = $createInAppDirectory? 'app/commands' : 'original/commands/builtIn';
        $this->templateFile = $templateFile;
        $this->dataToPassToTemplate = $dataToPassToTemplate;
    }
    
    protected function getClassName() : string
    {
        return "{$this->commandNameNoSuffix}Command";
    }

    protected function getNamespace() : string
    {
        if ($this->createInAppDirectory) {
            return "{$this->getBaseNamespace()}\\App\\Commands";
        }

        return "{$this->getBaseNamespace()}\\Original\\Commands\\BuiltIn";
    }

    protected function getRelativeDirectory() : string
    {
        return $this->relativeDirectory;
    }

    protected function getTemplatePath() : string
    {
        return $this->templateFile ?? dirname(__FILE__).'/CommandTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return $this->dataToPassToTemplate->asArray();
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $defaultVariables = [
            'createInAppDirectory' => $this->createInAppDirectory,
            'fullyQualifiedClassName' => $this->getFullyQualifiedClassName(),
            'className' => $this->getClassName()
        ];

        return array_merge(parent::getDataToPassToTasks(), $defaultVariables, $this->getTemplateVariables());
    }
}