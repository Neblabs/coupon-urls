<?php

namespace CouponURLs\Original\Creators\Model\Model;

use CouponURLs\Original\Creators\ModelTemplateProjectFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;

Class ModelFileCreator extends ModelTemplateProjectFileCreator
{
    protected function getModelTypeName() : string
    {
        return 'model';
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/ModelTemplate.php';
    }
}