<?php

return <<<TEMPLATE
<?php

namespace {$this->getModelNamespace()};

use CouponURLs\App\Data\Schema\\{$this->singularName}Table;
use CouponURLs\Original\Data\Model\Gateway;
use {$this->getModelNamespace()}\\{$this->singularName};

Class {$this->getGatewayName()} extends Gateway
{
    protected function model()
    {
        return [
            'table' => new {$this->getTableName()},
            'domain' => {$this->singularName}::class
        ];
    }

    public function GetWithId(\$id)
    {
        return \$this->createCollection(
                    (array) \$this->driver->get("SELECT * FROM {\$this->table->getName()} WHERE id = ?", [\$id])
                )->first();
    }   

}
TEMPLATE;
