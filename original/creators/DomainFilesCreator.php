<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Creators;
use CouponURLs\Original\Creators\Model\Domain\EntitiesTemplate\EntitiesTemplateFileCreator;
use CouponURLs\Original\Creators\Model\Domain\EntityFileCreator;
use CouponURLs\Original\Creators\Model\Domain\EntityTemplate\EntityTemplateFileCreator;
use CouponURLs\Original\Creators\Model\Domains\EntitiesFileCreator;
use CouponURLs\Original\Creators\Model\ModelMeta;
use CouponURLs\Original\Creators\Tasks\TestFileCreatorTask;
use CouponURLs\Original\Language\Classes\Properties;

Class DomainFilesCreator extends Creators
{
    protected $modelMeta;    
    protected $properties;
    protected bool $createEntityTemplateFiles;
    public function __construct(string $singularName, string $pluralName, Properties $properties, bool $createEntityTemplateFiles, string $directoryRelativeToDomain = null)
    {
        $this->modelMeta = new ModelMeta($singularName, $pluralName, $directoryRelativeToDomain);
        $this->createEntityTemplateFiles = $createEntityTemplateFiles;
        $this->properties = $properties;
    }

    protected function getCreators() : Collection
    {
        (object) $creators = Collection::create([
            (object) $entityCreator = new EntityFileCreator($this->modelMeta),
            new EntitiesFileCreator($this->modelMeta),
            $this->createEntityTemplateFiles ? new EntityTemplateFileCreator($this->modelMeta): null,
            $this->createEntityTemplateFiles ? new EntitiesTemplateFileCreator($this->modelMeta): null,
        ])->filter();

        $entityCreator->setProperties($this->properties);
        
        foreach ($creators as $creator) {
            $creator->registerCompletionTasks([
                new TestFileCreatorTask
            ]);
        }

        return $creators; 
    }
}