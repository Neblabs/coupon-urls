<?php

namespace CouponURLs\Original\Creators\Dependency;

use CouponURLs\Original\Creators\ClassFileCreator;

use function CouponURLs\Original\Utilities\Text\i;

Class DependencyFileCreator extends ClassFileCreator
{
    public function __construct(
        protected string $name,
        protected bool $createInOriginal
    ) {}
    
    protected function getClassName() : string
    {
        return i($this->name)->ensureRight('Dependency')->get();
    }

    protected function getRelativeDirectory() : string
    {
        return match($this->createInOriginal) {
            true => 'original/dependency/builtIn',
            false => 'app/dependencies'
        };
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/DependencyTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $defaultVariables = [
            'createInOriginalDirectory' => $this->createInOriginal,
            'fullyQualifiedClassName' => $this->getFullyQualifiedClassName(),
            'className' => $this->getClassName()
        ];

        return array_merge(parent::getDataToPassToTasks(), $defaultVariables, $this->getTemplateVariables());
    }
}