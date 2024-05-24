<?php

return <<<TEMPLATE
<?php

namespace CouponURLs\App\Components{$extraNamespaces};

use CouponURLs\Original\Presentation\Component;

Class {$typeName} extends Component
{
    protected \$file = '{$nonCapitalizedTypeName}.php';
}
TEMPLATE;
