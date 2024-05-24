<?php
return <<<TEMPLATE
<?php declare(strict_types=1);

namespace {$namespace};

use WP_UnitTestCase;
{$groupRenderer->render()}
Class {$className} extends WP_UnitTestCase
{
    public function set_up()
    {
        parent::set_up();
        
        //...
    }
    
    public function test_()
    {

    }
}
TEMPLATE;
