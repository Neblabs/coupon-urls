<?php

namespace CouponURLs\Original\Creators\Model\Gateway;

use CouponURLs\Original\Creators\ModelTemplateProjectFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;

Class GatewayFileCreator extends ModelTemplateProjectFileCreator
{
    protected function getModelTypeName() : string
    {
        return 'gateway';
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/gatewayTemplate.php';
    }
}