<?php

namespace CouponURLs\Original\Data\Model;

use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Drivers\DatabaseDriver;
use CouponURLs\Original\Data\Model\Domains;
use CouponURLs\Original\Data\Schema\DatabaseTable;
use CouponURLs\Original\Utilities\TypeChecker;
use BadMethodCallException;

Abstract Class Gateway
{
    use TypeChecker;

    protected $schema;
    protected $domainType;
    protected $driver;

    protected $cache;
    
    abstract protected function model() : array;
    abstract public function insert(Domain $domain);
    abstract public function update(Domain $domain);
    abstract public function delete(Domain $domain);

    public function __construct(DatabaseDriver $driver, $bind = null)
    {
        $this->table = $this->expect($this->model()->getTable())->toBe(DatabaseTable::class);
        $this->domainType = $this->model()->getDomainClass();

        $this->cache = new MemoryCache([]);

        $this->driver = $driver;
        $this->valueToBind = $bind;
    }

    protected function executeInstruction(Instruction $instruction) : Collection
    {
        (array) $set = $this->driver->execute($instruction);

        return $this->entitiesCreatorMappper->create($set);

        return $this->createCollection(
            (array) $this->driver->execute($instruction)
        );
    }
    
    public function getAll()
    {
        return $this->createCollection(
            $this->driver->execute(
                "SELECT * FROM {$this->table->getName()} ORDER BY {$this->table->getPrimaryKey()} DESC"
            )
        );
    }
    
    public function fieldWithValueExists(Array $field)
    {
        (string) $fieldName = $this->table->getField($field['name']);

        return $this->createCollection(
            (array) $this->driver->get(
                "SELECT {$this->table->getPrimaryKey()} 
                 FROM {$this->table->getName()} 
                 WHERE {$fieldName} = ?", 
                [
                    $field['value']
                ]
            )
        )->haveAny();
    }

    public function hasFieldWithValue(Array $field)
    {
        (string) $fieldName = $this->table->getField($field['name']);

        return $this->createCollection(
            $this->driver->get(
                "SELECT {$this->table->getPrimaryKey()} 
                 FROM {$this->table->getName()} 
                 WHERE {$this->table->getPrimaryKey()} = ? and {$fieldName} = ?", 
                [
                    $field[$this->table->getPrimaryKey()],
                    $field['value']
                ]
            )
        )->haveAny();
    }

    public function createTypedGroup(array $set) : Domains
    {
        (object) $entitiesCreatorMapper = $this->createEntitiesCreatorMapper();

        return $entitiesCreatorMapper->create($set);

        (string) $TypedGroup = $this->model()->getDomainsClass();
        
        return new $TypedGroup($this->createCollection($set));
    }

    protected function createCollection(array $set) : Collection
    {
        return (new Collection($set))->map(function(array $entityData) : Entity {
            (object) $creatorMapper = $this->createCreatorMapper();

            return $creatorMapper->create($entityData);
        });

        return (new Collection($set))->map(function($entity) {
            (string) $Domain = $this->domainType;

            (object) $domain = new $Domain($entity, $this->valueToBind);

            return $domain;
        });
    }
    
    protected function getFields(Domain $domain)
    {
        return trim(implode(', ', $domain->getAvailableFields()), ', ');
    }

    protected function getValuesAsMark(Domain $domain)
    {
        return trim(str_repeat('?, ',  count($domain->getAvailableValues())), ', ');
    }

}