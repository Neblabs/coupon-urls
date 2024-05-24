<?php

namespace CouponURLs\Original\Language;

use CouponURLs\Original\Collections\Collection;

Class Types
{
    const STRING_ID = 1;
    const INETEGER_ID = 2;
    const FLOAT_ID = 3;
    const ARRAY_ID = 4;
    const COLLECTION_ID = 5;
    const CLASS_ID = 6;

    const NATIVE = [ 
        0 => '', #no type
        self::STRING_ID => 'string',
        self::INETEGER_ID => 'int',
        self::FLOAT_ID => 'float',
        self::ARRAY_ID => 'array',
    ];

    const USER = [
        self::COLLECTION_ID => 'collection',
        self::CLASS_ID => 'class'
    ];

    public function getNative() : array
    {
        return static::NATIVE;
    }

    public function isNative(/*string|int*/ $type) : bool
    {
        return in_array(strtolower($type), $this->getNative());
    }    

    public function getNameFromId(int $id) : string
    {
        return $this->getAll()->get($id);
    }
    
    public function getAll() : Collection
    {
        return new Collection(
            array_merge(static::NATIVE, static::USER)
        );
    }
}