<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Creation\Actions\ActionsFactory;
use CouponURLs\App\Creation\Coupons\CouponFactory;
use CouponURLs\App\Creation\Coupons\CouponOptionsFromCouponFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\CouponURLsFromCouponIdFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\QueryParametersFromStringMatchingCurrentRequestFactory;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Data\Finders\Couponurls\CouponURLsFinder;
use CouponURLs\App\Data\Schema\PostMetaStructure;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Data\Drivers\SQL\WordPressDatabaseReadableDriver;
use CouponURLs\Original\Data\Query\GenericSQLParameters;
use CouponURLs\Original\Data\Query\SQLParameters;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use NilPortugues\Sql\QueryBuilder\Builder\MySqlBuilder;
use WC_Discounts;
use wpdb;

class CouponURLsFinderDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected wpdb $wpdb,
        protected WC_Discounts $discounts,
        protected ActionsFactory $actionsFactory,
        protected CouponOptionsFromCouponFactory $optionsFactory,
        protected URI $requestURI
    ) {}
    
    static public function type(): string
    {
        return CouponURLsFinder::class;   
    } 

    public function create(): CouponURLsFinder
    {
        return new CouponURLsFinder(
            readableDriver: new WordPressDatabaseReadableDriver($this->wpdb),
            parameters: new GenericSQLParameters(new PostMetaStructure),
            entityFactory: new QueryParametersFromStringMatchingCurrentRequestFactory(
                new QueryParametersFromStringFactory,
                new CouponURLsFromCouponIdFactory(
                    couponFactory: new CouponFactory($this->discounts),
                    actionsFactory: $this->actionsFactory,
                    optionsFactory: $this->optionsFactory
                ),
                requestURI: $this->requestURI
            )
        );
    } 
}