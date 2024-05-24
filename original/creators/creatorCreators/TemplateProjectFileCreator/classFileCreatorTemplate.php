<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use CouponURLs\Original\Creators\ClassFileCreator;

Class {$className} extends ClassFileCreator
{
    protected function getClassName() : string
    {
        return '';
    }

    protected function getRelativeDirectory() : string
    {
        return '';
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/{$templateName}';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) \$customData = [
        ];

        return array_merge(parent::getDataToPassToTasks(), \$customData, \$this->getTemplateVariables());
    }
}
TEMPLATE;
