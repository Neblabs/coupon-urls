<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Components\Options\CouponOptionsComponent;
use CouponURLs\App\Creation\Coupons\CouponOptionsFromCouponFactory;
use CouponURLs\App\Creation\Coupons\CouponOptionsFromTemplateFactory;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;

class OptionsFactoryDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected CouponOptionsComponent $couponOptionsComponent
    ) {}
    
    static public function type(): string
    {
        return CouponOptionsFromCouponFactory::class;   
    } 

    public function create(): CouponOptionsFromCouponFactory
    {
        return new CouponOptionsFromCouponFactory(
            $this->couponOptionsComponent,
            new OptionsFromTemplateAndOptionableFactory,
        );
    } 
}