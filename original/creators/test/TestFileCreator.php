<?php

namespace CouponURLs\Original\Creators\Test;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creators\ClassFileCreator;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Renderers\Abilities\Renderable;
use CouponURLs\Original\Renderers\Comments\AnnotationRenderer;
use CouponURLs\Original\Renderers\Comments\DocCommentLineRenderer;
use CouponURLs\Original\Renderers\Comments\DocCommentRenderer;
use CouponURLs\Original\Renderers\Comments\KeyValueAnnotationRenderer;
use CouponURLs\Original\Renderers\Language\NewLineRenderer;
use CouponURLs\Original\Renderers\Language\TextRenderer;

use function CouponURLs\Original\Utilities\Text\i;

Class TestFileCreator extends ClassFileCreator
{
    public function __construct(string $absoluteFilePath, string $testGroup = null, Collection $taskData, string $customTemplatePathAbsolute = '', string $baseTargetDirectory = '')
    {
        $this->absoluteFilePath = $absoluteFilePath;
        $this->testGroup = $testGroup;
        $this->customTemplatePathAbsolute = $customTemplatePathAbsolute;
        $this->taskData = $taskData;
        $this->baseTargetDirectory = $baseTargetDirectory;
    }

    protected function validateBeforeCreating()
    {
        (array) $fileParts = $this->getFileParts();

        if (strpos($fileParts['dirname'], Env::directory()) !== 0) {
            throw new \Exception('file must be inside the current plugin directory. Given Path: '.$this->absoluteFilePath);
        }

        if (strtolower($fileParts['extension']) !== 'php') {
            throw new \Exception('file must be a php file. Given Filename: '.$fileParts['filename']);
        }   
    }

    protected function getFileParts() : array
    {
        return pathinfo($this->absoluteFilePath);
    }
    
    protected function getClassName() : string
    {
        (string) $originalFileName = ucfirst($this->getFileParts()['filename']);

        return "{$originalFileName}Test";
    }

    protected function getRelativeDirectory() : string
    {
        return i($this->baseTargetDirectory ?: "tests/unit")->append("/{$this->getRelativeOriginalDirectoryPath()}")->get();
    }

    protected function getRelativeOriginalDirectoryPath() : string
    {
        (string) $aboslutePath = $this->getFileParts()['dirname'];

        return str_replace(Env::directory(), '', $aboslutePath);
    }

    protected function getTemplatePath() : string
    {

        return $this->customTemplatePathAbsolute ?: dirname(__FILE__).'/PESTTestTemplate.php';;
        //this used to be for phpunit tests
        return dirname(__FILE__).'/TestTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [
            'groupRenderer' => $this->getGroupRenderer(),
            'originalFileData' => $this->taskData
        ];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $defaultVariables = [
        ];

        return array_merge(parent::getDataToPassToTasks(), $defaultVariables, $this->getTemplateVariables());
    }

    protected function getGroupRenderer() : Renderable
    {
        if ($this->testGroup) {
            return new DocCommentRenderer(
                new DocCommentLineRenderer(
                    new AnnotationRenderer(
                        new KeyValueAnnotationRenderer(
                            $name = 'group',
                            $value = $this->testGroup
                        )
                    )
                )
            );
        }

        return new TextRenderer;
    }
}