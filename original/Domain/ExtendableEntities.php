<?php

namespace CouponURLs\Original\Domain;

use CouponURLs\Original\Collections\Collection;

abstract class ExtendableEntities extends Entities
{
    public function set(Collection|array $entities) : ExtendableEntities
    {
        $this->setEntities($entities);
        
        return $this;
    }

    public function append(Entity $entity) : ExtendableEntities
    {
        $this->entities->push($entity);
        return $this;
    }

    public function prepend(Entity $entity) : ExtendableEntities
    {
        $this->entities->pushAtTheBeginning($entity);
        return $this;
    }
}