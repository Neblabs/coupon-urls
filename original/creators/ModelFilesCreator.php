<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Abilities\Creator;
use CouponURLs\Original\Creators\Creators;
use CouponURLs\Original\Creators\Model\Domain\EntityFileCreator;
use CouponURLs\Original\Creators\Model\Domains\EntitiesFileCreator;
use CouponURLs\Original\Creators\Model\Gateway\GatewayFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;
use CouponURLs\Original\Creators\Model\Model\ModelFileCreator;
use CouponURLs\Original\Creators\Model\Table\TableFileCreator;
use CouponURLs\Original\Environment\Env;

Class ModelFilesCreator extends Creators
{
    protected $modelMeta;    

    public function __construct(string $singularName, string $pluralName)
    {
        $this->modelMeta = new ModelMeta($singularName, $pluralName);   
    }

    protected function getCreators() : Collection
    {
        return new Collection([
            //+new GatewayFileCreator($this->modelMeta),
            //out: new EntityFileCreator($this->modelMeta),
            //out: new EntitiesFileCreator($this->modelMeta),
            //+new ModelFileCreator($this->modelMeta),
            //+new TableFileCreator($this->modelMeta),
        ]);
    }
}