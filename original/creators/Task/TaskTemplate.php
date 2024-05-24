<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$settings->app->namespace}\Original\Collections\Collection;
use {$settings->app->namespace}\Original\Environment\Env;
use {$settings->app->namespace}\Original\Tasks\Task;

Class {$className} extends Task
{
    public function run(Collection \$taskData)
    {

    }
}
TEMPLATE;
