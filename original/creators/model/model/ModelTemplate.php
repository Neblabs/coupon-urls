<?php

return <<<TEMPLATE
<?php

namespace {$currentModelMeta->getNamespace()};

use {$modelMeta->getforComponent('table')->getFullyQualifiedClassName()};
use {$modelMeta->getforComponent('table')->getParentFullyQualifiedClassName()};
use {$modelMeta->getforComponent('domain')->getFullyQualifiedClassName()};
use {$modelMeta->getforComponent('domains')->getFullyQualifiedClassName()};
use {$currentModelMeta->getParentFullyQualifiedClassName()};

Class {$currentModelMeta->getClassName()} extends {$currentModelMeta->getParentClassName()}
{
    public function getDomainClass() : string
    {
        return {$modelMeta->getforComponent('domain')->getClassName()}::class;
    }

    public function getDomainsClass() : string
    {
        return {$modelMeta->getforComponent('domains')->getClassName()}::class;
    }

    public function getTable() : {$modelMeta->getforComponent('table')->getParentClassName()}
    {
        return new {$modelMeta->getforComponent('table')->getClassName()};
    }
}
TEMPLATE;
