<?php

namespace CouponURLs\Original\Data\Schema;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Schema\DatabaseColumn;
use CouponURLs\Original\Data\Schema\DatabaseColumnChanges;
use CouponURLs\Original\Utilities\TypeChecker;
use CouponURLs\Original\Utilities\className;

Abstract Class Schema
{
    use className;
    use TypeChecker;

    protected $name;
    protected $fields = [];
    protected $primary;

    /**
     * The name that identifies where the entities are stored.
     * For example, a database table name or a file name.
     */
    abstract protected function name() : string;
    abstract protected function fields() : array;   

    public function __construct()
    {
        $this->name = strtolower($this->name());
        $this->fields = (array) $this->expectEach($this->fields())->toBe(DatabaseColumn::class);
        $this->primary = $this->fields['primary'];
    }

    public function getName()
    {
        return (new StringManager($this->name))->getAlphanumeric();
    }

    public function getFields()
    {
        return new Collection((array) $this->fields);
    }

    public function getFieldNames()
    {
        return $this->getFields()->map(function(DatabaseColumn $field) {
            return $field->getName();
        });
    }

    public function getField($fieldName)
    {
        /*mixed*/ $field = $this->getFields()->filter(function(DatabaseColumn $field) use ($fieldName) {
            return $field->getName() === (string) $fieldName;
        })->first();

        return $field? $field->getName() : null;
    }

    public function getPrimaryKey()
    {
        return $this->primary->getName();
    }

    public function map(array $fields)
    {
        return new DatabaseTableMapper($this, $fields);
    }

    public function getFieldsDefinition()
    {
        return implode(', ', array_map(function(DatabaseColumn $field) {
            return $field->getDefinition();
        }, $this->fields));
    }

    public function additions()
    {
        return array_filter($this->getChanged('additions'), function(DatabaseColumn $fieldToAdd){
            return $this->hasFieldWithName($fieldToAdd->getName());
        });
    }

    public function deductions()
    {
        return array_filter($this->getChanged('deductions'), function(DatabaseColumn $fieldToRemove){
            return !$this->hasFieldWithName($fieldToRemove->getName());
        });
    }

    /*
     Changing a column name and then later on adding another one with the old name is
     not supported and may introduce some serious bugs.
     */
    public function transforms()
    {
        return array_filter($this->getChanged('transforms'), function(DatabaseColumnChanges $columnChanges){
            return $this->hasFieldWithName($columnChanges->getNewColumn()->getName());
        });
    }

    public function getChanged($type)
    {
        return isset($this->changes()[$type])? $this->changes()[$type] : [];
    }

    public function hasFieldWithName($name)
    {
        foreach ($this->getFields()->asArray() as $field) {
            if ($field->getName() === $name) {
                return true;
            }
        }
    }

}