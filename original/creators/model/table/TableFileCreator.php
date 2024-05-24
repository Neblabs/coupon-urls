<?php

namespace CouponURLs\Original\Creators\Model\Table;

use CouponURLs\Original\Creators\ModelTemplateProjectFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;

Class TableFileCreator extends ModelTemplateProjectFileCreator
{
    protected function getModelTypeName() : string
    {
        return 'table';
    }
    
    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/TableTemplate.php';
    }
}