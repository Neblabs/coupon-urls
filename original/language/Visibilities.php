<?php

namespace CouponURLs\Original\Language;

Class Visibilities
{
    const PUBLIC_ID = 1;
    const READONLY_ID = 2;
    const PRIVATE_ID = 3;

    const ALL = [
        self::PUBLIC_ID => 'public',
        self::READONLY_ID => 'readonly',
        self::PRIVATE_ID => 'private',
    ];

    public function getNameFromId(int $id) : string
    {
        return static::ALL[$id];   
    }
    
}