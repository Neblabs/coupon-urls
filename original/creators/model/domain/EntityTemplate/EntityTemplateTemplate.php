<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$modelMeta->getNamespace()}\\{$modelMeta->getNameSingular()};
use {$settings->app->namespace}\App\Domain\Data\Abilities\DataSetCollection;
use {$settings->app->namespace}\App\Domain\Data\TextTemplate;
use {$settings->app->namespace}\App\Domain\Templates\EntityTemplate;
use {$settings->app->namespace}\Original\Collections\Collection;
use {$settings->app->namespace}\Original\Collections\Mapper\Types;
use {$settings->app->namespace}\Original\Domain\Entity;
use function {$settings->app->namespace}\Original\Utilities\Collection\_;

class {$className} extends EntityTemplate
{
    protected TextTemplate \$email;

    static public function definition() : Collection
    {
        return _(

        );
    }

    public function create(DataSetCollection \$eventData): {$modelMeta->getNameSingular()}
    {
        (object) \$mapped = \$this->map(\$eventData);

        return new {$modelMeta->getNameSingular()}(
            //email: \$mapped->email
        );
    } 
}
TEMPLATE;