<?php

namespace CouponURLs\Original\Creators;

use CouponURLs\Original\Environment\Env;

Abstract Class TemplateProjectFileCreator extends ProjectFileCreator
{
    abstract protected function getTemplatePath() : string;
    abstract protected function getVariablestoPassToTemplate() : array;

    protected function getFileContents() : string
    {
        extract($this->getTemplateVariables());

        return require $this->getTemplatePath();
    }

    protected function getTemplateVariables() : array
    {
        (array) $defaultVariables = [
            'settings' => Env::settings(),
            'self' => $this
        ];

        return array_merge($defaultVariables, $this->getVariablestoPassToTemplate());
    }
}