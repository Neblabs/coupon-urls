<?php

return <<<TEMPLATE
<?php

namespace {$fullyQualifiedNamespace};

use {$settings->app->namespace}\Original\Events\Handler\EventHandler;

Class {$className} extends EventHandler
{
    protected \$numberOfArguments = {$numberOfArguments};
    protected \$priority = {$priority};

    public function execute()
    {
        
    }
}
TEMPLATE;
