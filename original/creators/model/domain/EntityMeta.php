<?php

namespace CouponURLs\Original\Creators\Model\Domain;

use CouponURLs\Original\Creators\Model\ModelComponentMeta;
use CouponURLs\Original\Environment\Env;

Class EntityMeta extends ModelComponentMeta
{
    public function getClassName() : string
    {
        return $this->modelMeta->getNameSingular();
    }

    public function getParentClassName() : string
    {
        return 'Entity';   
    }

    public function getParentNamespace() : string
    {
        return Env::getwithBaseNamespace('Original\\Domain');
    }
}