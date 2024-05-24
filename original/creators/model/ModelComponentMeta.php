<?php

namespace CouponURLs\Original\Creators\Model;

use CouponURLs\Original\Creators\Model\ModelMeta;
use CouponURLs\Original\Environment\Env;

Abstract Class ModelComponentMeta
{
    protected $modelMeta;

    abstract public function getClassName() : string;
    abstract public function getParentClassName() : string;

    public function __construct(ModelMeta $modelMeta)
    {
        $this->modelMeta = $modelMeta;
    }

    public function getFullyQualifiedClassName()
    {
        return "{$this->getNamespace()}\\{$this->getClassName()}";
    }

    public function getNamespace() : string
    {
        return $this->modelMeta->getNamespace();
    }

    public function getParentFullyQualifiedClassName()
    {
        return "{$this->getParentNamespace()}\\{$this->getParentClassName()}";
    }   
 
    public function getParentNamespace() : string
    {
        return Env::getwithBaseNamespace('Original\\Data\\Model');
    }
 }