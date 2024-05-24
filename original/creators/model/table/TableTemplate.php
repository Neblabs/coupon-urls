<?php

return <<<TEMPLATE
<?php

namespace {$currentModelMeta->getNamespace()};

use {$settings->app->namespace}\Original\Data\Schema\DatabaseColumn;
use {$settings->app->namespace}\Original\Environment\Env;
use {$currentModelMeta->getParentFullyQualifiedClassName()};

Class {$currentModelMeta->getClassName()} extends {$currentModelMeta->getParentClassName()}
{
    protected function name()
    {
        return Env::getWithPrefix('{$this->modelMeta->getNamePlural()->toLowerCase()}');
    }

    protected function fields()
    {
        return [
            'primary' => new DatabaseColumn('id',  'integer', 'NOT NULL UNIQUE AUTO_INCREMENT'),
        ];
    }

    protected function changes()
    {
        return [
            'transforms' => [
                //[
                //    'from' => new DatabaseColumn('id',         'integer'),
                //    'to' => new DatabaseColumn('identifier',         'integer'),
                //]
            ],
            'additions' => [
            ],
            'deductions' => [
            ]
        ];
    }
}
TEMPLATE;
