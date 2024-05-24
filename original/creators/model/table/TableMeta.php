<?php

namespace CouponURLs\Original\Creators\Model\Table;

use CouponURLs\Original\Creators\Model\ModelComponentMeta;
use CouponURLs\Original\Environment\Env;

Class TableMeta extends ModelComponentMeta
{
    public function getClassName() : string
    {
        return "{$this->modelMeta->getNamePlural()}Table";
    }

    public function getParentClassName() : string
    {
        return 'DatabaseTable';   
    }

    public function getNamespace() : string
    {
        return Env::getwithBaseNamespace("App\\Data\\Model");
    }

    public function getParentNamespace() : string
    {
        return Env::getwithBaseNamespace('Original\\Data\\Schema');
    }
}