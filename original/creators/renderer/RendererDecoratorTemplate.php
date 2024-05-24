<?php

return <<<TEMPLATE
<?php

namespace {$namespace};

use {$baseClassNamespace}\\{$baseClassName};

Class {$className} extends {$baseClassName}
{
    public function render() : string
    {
        return "{\$this->renderer->render()}";
    }
}
TEMPLATE;
