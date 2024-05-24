<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$settings->app->namespace}\Original\Validation\ValidationResult;
use {$settings->app->namespace}\Original\Validation\Exceptions\ValidationException;
use {$baseClassNamespace}\\{$baseClassName};
use Exception;

Class {$className} extends {$baseClassName}
{
    public function __construct()
    {

    }
    
    public function execute() : ValidationResult
    {
        return \$this->passWhen(true);
    }

    protected function getDefaultException() : Exception
    {
        return new ValidationException;
    }
}
TEMPLATE;
