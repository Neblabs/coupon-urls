<?php

namespace CouponURLs\Original\Domain;

use CouponURLs\Original\Collections\Collection;

Abstract Class Entities
{
    protected Collection $entities;

    abstract protected function getDomainClass() : string;

    public function __construct(Collection|array $entities)
    {
        $this->setEntities($entities);
    }

    protected function setEntities(Collection|array $entities) : void
    {
        $entities = new Collection($entities);
        $this->throwExceptionIfItDoesNotContainDomainType($entities);
        $this->entities = $entities;
    }

    public function asCollection() : Collection
    {
        return clone $this->entities;
    }

    protected function throwExceptionIfItDoesNotContainDomainType(Collection $items)
    {
        (boolean) $hasItemsThatAreNotOfTheType = $items->have(function($item) : bool {
            (string) $domainClass = $this->getDomainClass();
            return !($item instanceof $domainClass);
        });

        if ($hasItemsThatAreNotOfTheType) {
            throw new \UnexpectedValueException("Collection can only contain instances of {$this->getDomainClass()}");
        }
    }
}