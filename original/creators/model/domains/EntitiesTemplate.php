<?php

return <<<TEMPLATE
<?php

namespace {$currentModelMeta->getNamespace()};

use {$currentModelMeta->getParentFullyQualifiedClassName()};

Class {$currentModelMeta->getClassName()} extends {$currentModelMeta->getParentClassName()}
{
    protected function getDomainClass() : string
    {
        return {$modelMeta->getForComponent('entity')->getClassName()}::class;
    }
}
TEMPLATE;
