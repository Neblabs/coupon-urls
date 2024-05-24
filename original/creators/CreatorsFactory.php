<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Abilities\Creator;
use CouponURLs\Original\Creators\CreatorCreators\ProjectFileCreator\ProjectFileCreatorCreators;
use CouponURLs\Original\Creators\CreatorCreators\TemplateProjectFileCreator\ClassFileCreatorCreators;
use CouponURLs\Original\Creators\CreatorCreators\TemplateProjectFileCreator\TemplateProjectFileCreatorCreators;
use Exception;

Class CreatorsFactory implements Creator
{
    protected $creatorName;
    protected $creatorDirectory;

    const BASE = 'base';
    const TEMPLATE = 'template';

    public function __construct(string $pathAndCreatorNameFormat, string $creatorLevel = 'base', bool $createInAppDirectory)
    {
        $this->pathAndCreatorNameFormat = $pathAndCreatorNameFormat;
        $this->creatorLevel = $creatorLevel;
        $this->createInAppDirectory = $createInAppDirectory;
    }
    
    public function create()
    {
        switch ($this->creatorLevel) {
            case static::BASE:
                return new ProjectFileCreatorCreators($this->getCreatorName(), $this->getRelativeDirectory());
                break;
            case static::TEMPLATE:
                return new ClassFileCreatorCreators($this->getCreatorName(), $this->getRelativeDirectory());
                break;
            default:
                throw new Exception("Unknown creator level: $creatorLevel");
                break;
        }
    }

    protected function getCreatorName() : string
    {
        (object) $pathAndCreatorParts = new Collection(explode('/', $this->pathAndCreatorNameFormat));

        return $pathAndCreatorParts->last();   
    }
    
    protected function getRelativeDirectory() : string
    {
        return "{$this->getBaseDirectory()}/{$this->pathAndCreatorNameFormat}";
    }
    
    protected function getBaseDirectory() : string
    {
        $base = 'original';

        if ($this->createInAppDirectory) {
            $base =  'app';
        }

        return "{$base}/creators";
    }
    
}