<?php

namespace CouponURLs\Original\Creators\Handler;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Creators\ClassFileCreator;

Class HandlerFileCreator extends ClassFileCreator
{
    protected $handlerNameNoSuffix;
    protected $hookName;
    protected $hookPriority;
    protected $hookNumberOfArguments;

    public function __construct(string $handlerNameNoSuffix, string $hookName, int $hookPriority, int $hookNumberOfArguments)
    {
        $this->handlerNameNoSuffix = new StringManager($handlerNameNoSuffix);
        $this->hookName = $hookName;
        $this->hookPriority = $hookPriority;
        $this->hookNumberOfArguments = $hookNumberOfArguments;
    }
    
    protected function getClassName() : string
    {
        return "{$this->handlerNameNoSuffix->uppercaseFirst()}Handler";   
    }

    protected function getRelativeDirectory() : string
    {
        return 'app/handlers';
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/HandlerTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [
            'priority' => $this->hookPriority,
            'numberOfArguments' => $this->hookNumberOfArguments
        ];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $defaultVariables = [
            'className' => $this->getClassName(),
            'hookName' => $this->hookName,
        ];

        return array_merge(parent::getDataToPassToTasks(), $defaultVariables, $this->getTemplateVariables());
    }
}