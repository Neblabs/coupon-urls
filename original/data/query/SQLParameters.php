<?php

namespace CouponURLs\Original\Data\Query;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Schema\Fields\ID;
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;
use NilPortugues\Sql\QueryBuilder\Manipulation\Select;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;

class SQLParameters extends Parameters
{
    protected GenericBuilder $builder;
    protected Select $select;

    public function setInternalRelationship(ID $idField): void
    {
        $this->select->where()->equals(
            column: $this->structure->fields()->id()->name()->get(),
            value: $this->structure->fields()->id()->id()->get()
        );  
    } 

    public function reset(): void
    {
        $this->select = $this->builder->select();
        $this->select->setTable($this->structure->name());
    } 

    public function setBuilder(GenericBuilder $builder) : void
    {   
        $this->builder = $builder;
        $this->reset();
    }

    public function query() : Select
    {
        return $this->select;
    }

    public function queryString() : StringManager
    {
        return i($this->builder->write($this->select));
    }
 
    public function queryValues() : Collection
    {
        return _($this->builder->getValues());
    }
}