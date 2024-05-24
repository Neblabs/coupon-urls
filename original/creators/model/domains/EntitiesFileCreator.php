<?php

namespace CouponURLs\Original\Creators\Model\Domains;

use CouponURLs\Original\Creators\ModelTemplateProjectFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;

Class EntitiesFileCreator extends ModelTemplateProjectFileCreator
{
    protected function getModelTypeName() : string
    {
        return 'entities';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return array_merge(parent::getVariablestoPassToTemplate(), [
            'testGroup' => 'entity'
        ]);
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/EntitiesTemplate.php';
    }
}