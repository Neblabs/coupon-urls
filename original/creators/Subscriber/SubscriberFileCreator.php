<?php

namespace CouponURLs\Original\Creators\Subscriber;

use CouponURLs\Original\Creators\ClassFileCreator;

use function CouponURLs\Original\Utilities\Text\i;

Class SubscriberFileCreator extends ClassFileCreator
{
    public function __construct(
        protected string $subscriberName,
        protected bool $createInOriginal
    ) {}
    
    protected function getClassName() : string
    {
        return i($this->subscriberName)->upperCaseFirst();
    }

    protected function getRelativeDirectory() : string
    {
        return match($this->createInOriginal) {
            false => 'app/subscribers',
            true => 'original/subscribers'
        };
    }

    protected function getTemplatePath() : string
    {
        return dirname(__FILE__).'/SubscriberTemplate.php';
    }

    protected function getVariablestoPassToTemplate() : array
    {
        return [];
    }

    protected function getDataToPassToTasks() : array
    {
        (array) $customData = [
            'createInOriginalDirectory' => $this->createInOriginal
        ];

        return array_merge(parent::getDataToPassToTasks(), $customData, $this->getTemplateVariables());
    }
}