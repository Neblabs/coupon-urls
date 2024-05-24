<?php

namespace CouponURLs\App\Creation\Coupons\Couponurls;

use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Domain\CouponURLs\CouponURLs;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters;
use CouponURLs\Original\Creation\Entities\Abilities\OverloadableEntitiesFactory;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

/**
 * Expects:
 * [
 *      ['id' => x, 'post_id' => y, 'meta_value' => '', etc],
 *      ['id' => x, 'post_id' => y, 'meta_value' => '', etc],
 *      ['id' => x, 'post_id' => y, 'meta_value' => '', etc],
 *      etc
 * ]
 */
class QueryParametersFromStringMatchingCurrentRequestFactory implements CreatableEntitiesWithParameters, OverloadableEntitiesFactory
{
    public function __construct(
        protected QueryParametersFromStringFactory $queryParametersFromStringFactory,
        protected CreatableEntitiesWithParameters $couponURLsFromCouponIdFactory,
        protected URI $requestURI
    ) {}
    
    /** @param array $entitesData */
    public function createEntities(mixed $entitesData, Parameters $parameters): CouponURLs
    {
        /*array|null*/ $macthingRow = _($entitesData)->find($this->canCreateEntity(...));

        return $this->couponURLsFromCouponIdFactory->createEntities(
            #empty if no matching uri!
            _($macthingRow['post_id'] ?? false)->filter(),
            $parameters
        );
    } 

    public function canCreateEntity(mixed $data): bool
    {
        return is_array($data) && isset($data['meta_value']) && $this->queryMatchesRequestQuery($data);
    } 

    public function canCreateEntities(mixed $data): bool
    {
        return is_array($data);    
    } 

    protected function queryMatchesRequestQuery(array $row) : bool
    {
        (object) $queryParameters = $this->queryParametersFromStringFactory->create($row['meta_value']);

        return $this->requestURI->queryParameters()->hasAllOf($queryParameters);
    }
    
    public function createEntity(mixed $data, Parameters $parameters): Entity
    {
        return $this->couponURLsFromCouponIdFactory->createEntity($data['post_id'], $parameters);
    } 
}