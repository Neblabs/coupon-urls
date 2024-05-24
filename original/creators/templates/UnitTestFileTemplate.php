<?php
(string) $optionallyUseProductsLoader = ($testCaseType === 'DatabaseTestCase' ? "use ProductsDatabaseLoader;\n"  :'');

return <<<TEMPLATE
<?php declare(strict_types=1);

namespace {$fullyQualifiedNamespace};

use CouponURLs\Original\Tests\DataProviderLoader;
use CouponURLs\App\Tests\FilterAssertions;
use CouponURLs\App\Tests\OfferAssertions;
use CouponURLs\App\Tests\CouponComponents;
use CouponURLs\App\Tests\ProductsDatabaseLoader;
use CouponURLs\Original\Tests\DatabaseTestCase;
use WP_UnitTestCase;

Class {$typeName} extends {$testCaseType}
{
    use DataProviderLoader;
    use FilterAssertions;
    use OfferAssertions;    

    public function test_()
    {

    }
}
TEMPLATE;
