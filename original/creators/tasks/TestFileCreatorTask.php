<?php

namespace CouponURLs\Original\Creators\Tasks;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Test\TestFileCreator;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Tasks\Task;

Class TestFileCreatorTask extends Task
{
    public function __construct(
        protected string $customTemplatePathAbsolute = '',
        protected string $baseTargetDirectory = ''
    ) {}
    
    public function run(Collection $taskData)
    {
        (object) $testFileCreator = new TestFileCreator(
            $taskData->get('filePath'), 
            $taskData->get('testGroup'),
            $taskData,
            $this->customTemplatePathAbsolute,
            $this->baseTargetDirectory
        );

        $testFileCreator->create();
    }
}