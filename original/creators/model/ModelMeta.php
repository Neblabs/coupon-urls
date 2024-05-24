<?php

namespace CouponURLs\Original\Creators\Model;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Model\Domain\DomainMeta;
use CouponURLs\Original\Creators\Model\Domain\EntityMeta;
use CouponURLs\Original\Creators\Model\Domains\DomainsMeta;
use CouponURLs\Original\Creators\Model\Domains\EntitiesMeta;
use CouponURLs\Original\Creators\Model\Gateway\GatewayMeta;
use CouponURLs\Original\Creators\Model\Model\ModelMeta as ModelMetaComponent;
use CouponURLs\Original\Creators\Model\Table\TableMeta;
use CouponURLs\Original\Environment\Env;

Class ModelMeta
{
    protected $singularName;
    protected $pluralName;
    protected $modelComponentMetas;

    public function __construct(string $singularName, string $pluralName, string $directoryRelativeToDomain = null)
    {
        $this->singularName =  StringManager::create($singularName)->upperCaseFirst();
        $this->pluralName = StringManager::create($pluralName)->upperCaseFirst();
        $this->directoryRelativeToDomain = $directoryRelativeToDomain ?? $this->getNamePlural()->lowerCaseFirst();
        $this->setModelComponentMetas();
    }

    protected function setModelComponentMetas()
    {
        $this->modelComponentMetas = new Collection([
            'gateway' => new GatewayMeta($this),
            'entity' => new EntityMeta($this),
            'entities' => new EntitiesMeta($this),
            'model' => new ModelMetaComponent($this),
            'table' => new TableMeta($this),
        ]);     
    }

    public function getForComponent(string $modelComponent) : ModelComponentMeta
    {
        return $this->modelComponentMetas->get($modelComponent);
    }
    
    public function getNameSingular() : StringManager
    {
        return $this->singularName;   
    }

    public function getNamePlural() : StringManager
    {
        return $this->pluralName;   
    }
    
    public function getDirectory() : string
    {
        return "app/domain/{$this->directoryRelativeToDomain}";
    }
    
    public function getNamespace() : string
    {
        return Env::getNamespaceFromDirectory($this->getDirectory());
    }
}