<?php

namespace CouponURLs\Original\Data\Drivers;

use CouponURLs\Original\Data\Instructions\Instruction;
use CouponURLs\Original\Data\Schema\DatabaseColumn;
use CouponURLs\Original\Data\Schema\DatabaseTable;
use PDO;
use PDOStatement;

Class PDODatabaseDriver extends DatabaseDriver
{
    protected function setConnection()
    {
        $this->pdo = new PDO(
            "mysql:host={$this->credentials->get('host')};dbname={$this->credentials->get('name')}",
            $this->credentials->get('username'), 
            $this->credentials->get('password')
        );
    }

    public function execute(Instruction $instruction)
    {
        (object) $statement = $this->pdo->prepare($instruction->getStatement());

        $result = $statement->execute($instruction->getParameters());

        return $instruction->shouldGet()? $statement->fetchAll() : $result;   
    }

    public function escapeLike($value)
    {
        return $value;
    }
}