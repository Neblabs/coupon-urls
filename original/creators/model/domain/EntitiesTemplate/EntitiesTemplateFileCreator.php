<?php

namespace CouponURLs\Original\Creators\Model\Domain\EntitiesTemplate;

use CouponURLs\Original\Creators\ClassFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;

Class EntitiesTemplateFileCreator extends ClassFileCreator
{
    public function __construct(
        protected ModelMeta $modelMeta
    )
    {
    }

    protected function getClassName() : string
    {
        return "{$this->modelMeta->getNamePlural()}Template";
    }

    protected function getRelativeDirectory() : string
    {
        return "{$this->modelMeta->getDirectory()}/templates";
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/EntitiesTemplateTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [
            'modelMeta' => $this->modelMeta,
            'entityTemplateClassName' => "{$this->modelMeta->getNameSingular()}Template"
        ];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $customData = [
        ];

        return array_merge(parent::getDataToPassToTasks(), $customData, $this->getTemplateVariables());
    }
}