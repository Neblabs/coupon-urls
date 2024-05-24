<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\FactoryOverloader;

use function CouponURLs\Original\Utilities\Collection\_;

class ProductionDynamicTypeFactory
{
    public function create() : DynamicTypeFactory
    {
        return new DynamicTypeFactory(
            new FactoryOverloader(_(
                new DependentDynamicTypeFactory,
                new DependencyDynamicTypeFactory,
            ))
        );
    }
}