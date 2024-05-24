<?php

namespace CouponURLs\Original\Data\Schema;

use CouponURLs\Original\Data\Schema\DatabaseTable;

Class DatabaseTableMapper
{
    protected $existingFields;
    protected $newTable;

    protected $newColumns = [];
    protected $oldColumns = [];
    protected $columnChanges = [];

    public function __construct(DatabaseTable $newTable, array $existingFields)
    {
        $this->newTable = $newTable;
        $this->existingFields = $existingFields; 

        $this->compareTables();
    }

    public function getColumnsToAdd()
    {
        return (array) $this->newColumns;
    }

    public function getColumnsToRemove()
    {
        return (array) $this->oldColumns;
    }

    public function getColumnsToTransform()
    {
        return (array) $this->columnChanges;
    }

    public function applyToChanged(Callable $callable) {
        foreach ($this->getColumnsToAdd() as $columnToAdd) {
            $callable('add', $columnToAdd);
        }

        foreach ($this->getColumnsToRemove() as $columnToRemove) {
            $callable('remove', $columnToRemove);
        }

        foreach ($this->getColumnsToTransform() as $columnChanges) {
            $callable('transform', $columnChanges);
        }
    }

    protected function compareTables()
    {
        foreach ($this->newTable->additions() as $newColumn) {
            if (!in_array($newColumn->getName(), $this->getExistingFieldNames())) {
                $this->newColumns[] = $newColumn;
            }
        }

        foreach ($this->newTable->deductions() as $newColumn) {
            if (in_array($newColumn->getName(), $this->getExistingFieldNames())) {
                $this->oldColumns[] = $newColumn;
            }
        }

        foreach ($this->newTable->transforms() as $columnChanges) {
            if ($columnChanges->columnNeedsToBeUpdated($this->existingFields)) {
                $this->columnChanges[] = $columnChanges;
            }
        }
    }

    protected function getExistingFieldNames()
    {
        return array_map(function($field) {
            return strtolower($field);
        }, array_column($this->existingFields, 'Field'));
    }
}