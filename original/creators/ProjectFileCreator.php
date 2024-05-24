<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\Abilities\Creator;
use CouponURLs\Original\Creators\Exceptions\ExistingFileException;
use CouponURLs\Original\Creators\Tasks\NewClassFileLoggerTask;
use CouponURLs\Original\Environment\Env;
use RuntimeException;

Abstract Class ProjectFileCreator implements Creator
{
    abstract protected function getFileName() : string;
    abstract protected function getRelativeDirectory() : string;
    abstract protected function getFileContents() : string;

    /**
     * Overridable: Custom Validation
     */
    protected function validateBeforeCreating()
    {
        
    }
    
    /**
     * Overridable if you need to pass data to the tasks
     */
    protected function getDataToPassToTasks() : array
    {
        return [
            'filePath' => $this->getPath(),
            'fileName' => $this->getFileName(),
            'relativeDirectory' => $this->getRelativeDirectory(),
            'absoluteDirectory' => $this->getAbsoluteDirectory()
        ];
    }

    public function registerCompletionTasks(iterable $completionTasks)
    {
        $this->completionTasks = $completionTasks;
    }    

    public function create()
    {
        $this->validate();
        $this->createDirectoryIfNotExists();

        $this->saveFile();
        $this->runCompletionTasks();
    }

    protected function saveFile()
    {
        /*mixed*/$result = file_put_contents(
            $this->getPath(), 
            $this->getFileContents()
        );

        if ($result === false) {
            throw new RuntimeException("Could not save file: {$this->getPath()}");
        }
    }

    protected function validate()
    {
        $this->throwExceptionIfFileExists();
        $this->validateBeforeCreating();
    }

    protected function throwExceptionIfFileExists()
    {
        if (file_exists($this->getPath())) {
            throw new ExistingFileException("Can't create file: {$this->getPath()} bevause it already exists.");
        }
    }

    protected function createDirectoryIfNotExists()
    {
        if (!is_dir($this->getAbsoluteDirectory())) {
            mkdir($this->getAbsoluteDirectory(), 0777, $recursive = true);
        }
    }
    
    protected function getPath() : string
    {
        return "{$this->getAbsoluteDirectory()}/{$this->getFileName()}";
    }

    protected function getAbsoluteDirectory() : string
    {
        return Env::directory().$this->getRelativeDirectory();   
    }
    
    protected function runCompletionTasks()
    {
        foreach ($this->getCompletionTasks() as $task) {
            $task->run(
                new Collection($this->getDataToPassToTasks())
            );
        }
    }

    protected function getCompletionTasks() : array
    {
        $customCompletionTasks = [];
        if (isset($this->completionTasks) && is_array($this->completionTasks)) {
            $customCompletionTasks = $this->completionTasks;
        }

        return array_merge($this->getDefaultCompletionTasks(), $customCompletionTasks);
    }

    protected function getDefaultCompletionTasks() : array
    {
        return [
            new NewClassFileLoggerTask 
        ];
    }
}