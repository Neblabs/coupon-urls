<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$settings->app->namespace}\Original\Events\Parts\DefaultPriority;
use {$settings->app->namespace}\Original\Events\Subscriber;
use {$settings->app->namespace}\Original\Events\Wordpress\EventArguments;
use {$settings->app->namespace}\Original\Validation\Validator;
use {$settings->app->namespace}\Original\Validation\Validators\PassingValidator;

use function {$settings->app->namespace}\Original\Utilities\Collection\_;

Class {$className} implements Subscriber
{
    use DefaultPriority;

    public function createEventArguments() : EventArguments
    {
        return new EventArguments(_(
            //
        ));
    }

    public function validator() : Validator
    {
        return new PassingValidator;
    }

    public function execute() : void
    {
        //
    }
} 


TEMPLATE;
