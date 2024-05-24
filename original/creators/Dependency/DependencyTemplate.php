<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$settings->app->namespace}\Original\Dependency\Abilities\StaticType;
use {$settings->app->namespace}\Original\Dependency\WillAlwaysMatch;
use {$settings->app->namespace}\Original\Dependency\Dependency;
use {$settings->app->namespace}\Original\Abilities\Cached;

class {$className} implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    static public function type(): string
    {
        
    } 

    public function create(): object
    {
        
    } 
}
TEMPLATE;
