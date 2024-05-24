<?php

return <<<TEMPLATE
<?php

namespace {$currentModelMeta->getNamespace()};

use {$modelMeta->getForComponent('model')->getFullyQualifiedClassName()};
use {$modelMeta->getForComponent('table')->getParentFullyQualifiedClassName()};
use {$modelMeta->getForComponent('table')->getFullyQualifiedClassName()};
use {$modelMeta->getForComponent('domain')->getFullyQualifiedClassName()};
use {$currentModelMeta->getParentFullyQualifiedClassName()};

Class {$currentModelMeta->getClassName()} extends {$currentModelMeta->getParentClassName()}
{
    protected function model()
    {
        return new {$modelMeta->getForComponent('model')->getClassName()};
    }

    public function GetWithId(\$id)
    {
        return \$this->createCollection(
                    (array) \$this->driver->get("SELECT * FROM {\$this->table->getName()} WHERE id = ?", [\$id])
                )->first();
    }   

}
TEMPLATE;
