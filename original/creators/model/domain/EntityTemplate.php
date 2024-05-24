<?php

return <<<TEMPLATE
<?php

namespace {$modelMeta->getNamespace()};
{$propertyImportsRenderer->render()}
use {$currentModelMeta->getParentFullyQualifiedClassName()};

Class {$currentModelMeta->getClassName()} extends {$currentModelMeta->getParentClassName()}
{
{$propertiesRenderer->render()}

{$propertyMethodsRenderer->render()}
}
TEMPLATE;
