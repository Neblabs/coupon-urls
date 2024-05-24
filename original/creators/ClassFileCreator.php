<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\App\Tasks\PHPLinterTask;
use CouponURLs\Original\Environment\Env;

Abstract Class ClassFileCreator extends TemplateProjectFileCreator
{
    abstract protected function getClassName() : string;
    /*abstract*/ protected function getBaseClassName() : string { return ''; }
    /*abstract*/ protected function getBaseClassNamespace() : string { return ''; }

    protected function getFileName() : string
    {
        return "{$this->getClassName()}.php";
    }

    protected function getBaseNamespace() : string
    {
        return Env::settings()->app->namespace;   
    }

    protected function getNamespace() : string
    {
        return Env::getNamespaceFromDirectory($this->getRelativeDirectory());
    }

    protected function getFullyQualifiedClassName() : string
    {
        return "{$this->getNamespace()}\\{$this->getClassName()}";   
    }
    
    protected function getTemplateVariables() : array
    {
        (array) $defaultVariables = [
            'className' => $this->getClassName(),
            'baseClassName' => $this->getBaseClassName(),
            'namespace' => $this->getNamespace(),
            'baseClassNamespace' => $this->getBaseClassNamespace(),
            'fullyQualifiedClassName' => $this->getFullyQualifiedClassName()
        ];

        return array_merge($defaultVariables, parent::getTemplateVariables());
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $defaultVariables = [

        ];

        return array_merge(parent::getDataToPassToTasks(), $defaultVariables, $this->getTemplateVariables());
    }

    protected function getDefaultCompletionTasks() : array
    {
        return array_merge(parent::getDefaultCompletionTasks(), [
            new PHPLinterTask 
        ]);
    }
}