<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\App\Data\Finders\Conditions\ConditionsFinder;
use CouponURLs\App\Data\Finders\Conditions\ConditionsStructure;
use CouponURLs\Original\Data\Drivers\SQL\WordPressDatabaseReadableDriver;
use CouponURLs\Original\Data\Query\SQLParameters;

class ConditionsFinderDependency implements Dependency
{
    public function __construct(
        protected WordPressDatabaseReadableDriver $wordPressDatabaseReadableDriver,
        protected ConditionsStructure $conditionsStructure,
        protected ConditionsFactory $conditionsFactory
    ) {}

    public function canBeUsed(Context $context, Environment $environment): bool
    {
        return $environment->isProduction;
    } 

    public function create() : ConditionsFinder
    {
        return new ConditionsFinder(
            $this->wordPressDatabaseReadableDriver,
            new SQLParameters($this->conditionsStructure),
            $this->conditionsFactory
        );
    }
}