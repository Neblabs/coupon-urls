<?php

namespace CouponURLs\Original\Creation\Entities;

use CouponURLs\Original\Creation\Entities\Abilities\OverloadableEntitiesFactory;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use CouponURLs\Original\Creation\Abilities\CreatableEntities;
use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;
use Exception;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;

class OverloadedEntitiesFactory implements CreatableEntities
{
    public function __construct(
        protected Collection $overloadableFactories
    ) {
        validate(
            new ItemsAreOnlyInstancesOf(
                allowedTypes: _(OverloadableEntitiesFactory::class),
                items: $overloadableFactories
            )
        );
    }

    public function createEntity(mixed $data): Entity
    {
        foreach ($this->overloadableFactories as $factory) {
            if ($factory->canCreateEntity($data)) {
                return $factory->createEntity($data);
            }
        }

        throw new Exception("No create() factory match.");
    } 

    public function createEntities(mixed $entitesData): Entities
    {
        foreach ($this->overloadableFactories as $factory) {
            if ($factory->canCreateEntities($entitesData)) {
                return $factory->createEntities($entitesData);
            }
        }

        throw new Exception("No createEntities() factory match.");

        /**
        if ($entitesData  is  null) {
            fetch  from  database
        }

        if ($entitesData  is  String) {
            create  from Template
        }

        if ($entitesData  is  entitesTemplate) {
            create  from  EntitiesTemplateOjbect
        }

        if ($entitesData  is  an ArrayOrCollection) {
            create  from  raw  array  of  data
        }*/
    } 
}