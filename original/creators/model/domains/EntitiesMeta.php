<?php

namespace CouponURLs\Original\Creators\Model\Domains;

use CouponURLs\Original\Creators\Model\ModelComponentMeta;
use CouponURLs\Original\Environment\Env;

Class EntitiesMeta extends ModelComponentMeta
{
    public function getClassName() : string
    {
        return $this->modelMeta->getNamePlural();
    }

    public function getParentClassName() : string
    {
        return 'Entities';   
    }

    public function getParentNamespace() : string
    {
        return Env::getwithBaseNamespace('Original\\Domain');
    }
}