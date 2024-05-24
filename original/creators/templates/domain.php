<?php

return <<<TEMPLATE
<?php

namespace {$this->getModelNamespace()};

use CouponURLs\Original\Data\Model\Domain;

Class {$this->singularName} extends Domain
{

}
TEMPLATE;
