<?php

namespace CouponURLs\Original\Creators\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Tasks\Task;


Class DependencyRegistratorTask extends Task
{
    protected Collection $taskData;

    public function run(Collection $taskData)
    {
        $this->taskData = $taskData;

        (array) $registeredEventsFile = file_get_contents($this->getRegisterFile());

        (string) $fileWithUpdatedArray = $this->getWithNewEntryInArray($registeredEventsFile);

        $this->updateFile(
            $fileWithUpdatedArray
        );

        $this->updateFile(
            $this->getWithNamespaceAdded($fileWithUpdatedArray)
        );
    }

    protected function getWithNewEntryInArray(string $registerFileContent) : string
    {
        return preg_replace(
            '/\,\s+(\]\;)/', 
            ",\n    {$this->taskData->get('className')}::class,\n];", 
            $registerFileContent
        );
    }

    protected function getWithNamespaceAdded(string $registerFileContent) : string
    {
        return preg_replace('/\nreturn /', "use {$this->taskData->get('fullyQualifiedClassName')};\n\nreturn ", $registerFileContent);;
    }

    protected function updateFile(string $content)
    {
        file_put_contents(
            $this->getRegisterFile(),
            $content
        );   
    }
    

    protected function getRegisterFile() : string
    {
        return match($this->taskData->get('createInOriginalDirectory')) {
            false => Env::appDirectory().'dependencies/register.php',
            true => Env::originalDirectory().'dependency/builtIn/dependencies.php',
        };
    }
}