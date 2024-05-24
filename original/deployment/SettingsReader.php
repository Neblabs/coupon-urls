<?php

namespace CouponURLs\Original\Deployment;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Mappable;
use CouponURLs\Original\Collections\Mapper\Types;

Class SettingsReader extends Mappable
{
    public $settings;

    protected function getMap()
    {
        return [
            'repository' => Types::STRING(),
            'excludePrivateFiles' => Types::BOOLEAN()->withDefault(true),
            'excludePrivateDirectories' => Types::BOOLEAN()->withDefault(true),
            'filesToExclude' => Types::COLLECTION,
            'directoriesToExclude' => Types::COLLECTION,
            'scripts' => [
                'beforeClone' => Types::COLLECTION,
                'afterClone' => Types::COLLECTION,
                'afterCloningSingleFile' => Types::COLLECTION,
                'afterCompression' => Types::COLLECTION
            ]
        ];   
    }

    public function __construct()
    {
        (array) $settingsArray = require getcwd().'/.build.php';

        $this->settings = $this->map($settingsArray);

        if (!is_dir($this->settings->repository)) {
            throw new \Exception("Unexistent repository: '{$this->settings->repository}', please specify a target repository directory", 1);
            
        }
    }
     
    protected function getValuesToUnmap()
    {
       return $this->settings->asCollection();   
    }
}