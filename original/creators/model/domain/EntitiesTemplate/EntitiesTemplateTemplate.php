<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$modelMeta->getNamespace()}\\{$modelMeta->getNamePlural()};
use {$settings->app->namespace}\App\Domain\Templates\Abilities\EntitiesTemplateFactory;
use {$settings->app->namespace}\Original\Collections\Collection;
use {$settings->app->namespace}\Original\Domain\Entities;

class {$className} implements EntitiesTemplateFactory
{
    public function createEntityTemplate(string \$JSONTemplate) : {$entityTemplateClassName}
    {
        return new {$entityTemplateClassName}(\$JSONTemplate);
    }

    public function createEntities(Collection \$entities) : {$modelMeta->getNamePlural()}
    {
        return new {$modelMeta->getNamePlural()}(\$entities);
    }
}
TEMPLATE;
