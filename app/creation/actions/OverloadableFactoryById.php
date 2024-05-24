<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;

class OverloadableFactoryById implements OverloadableFactory, FactoryWithVariableArguments
{
    public function __construct(
        protected Identifiable $identifiable,
        protected FactoryWithVariableArguments $factoryWithVariableArguments
    ) {}
    
    public function canCreate(mixed $value): bool
    {
        return $value === $this->identifiable->identifier();
    } 

    public function create(...$arguments) : mixed
    {
        return $this->factoryWithVariableArguments->create(...$arguments);
    }
}