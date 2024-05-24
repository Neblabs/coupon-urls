<?php

namespace CouponURLs\App\Creation\Coupons\Couponurls;

use CouponURLs\App\Creation\Coupons\CouponFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl;
use CouponURLs\App\Domain\CouponURLs\CouponURLs;
use CouponURLs\App\Domain\CouponURLs\CouponURL;
use CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entity;

use function CouponURLs\Original\Utilities\Collection\_;

class CouponURLsFromCouponIdFactory implements CreatableEntitiesWithParameters
{
    public function __construct(
        protected CouponFactory $couponFactory,
        protected CreatableFromCouponUrl $actionsFactory,
        protected CreatableFromCouponUrl $optionsFactory
    ) {}
    
    /** @param int $data the coupon id */
    public function createEntity(mixed $data, Parameters $parameters): Entity
    {
        (object) $couponUrl = new CouponURL($this->couponFactory->createFromCodeOrID($data));

        $couponUrl->setActions($this->actionsFactory->createFromCoupon($couponUrl->coupon));
        $couponUrl->setOptions($this->optionsFactory->createFromCoupon($couponUrl->coupon));

        return $couponUrl;
    } 

    /** @param array<int> $entitesData */
    public function createEntities(mixed $entitesData, Parameters $parameters): CouponURLs
    {
        return new CouponURLs(_($entitesData)->map(fn(int $id) => $this->createEntity($id, $parameters)));
    } 
}