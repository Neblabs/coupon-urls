<?php

namespace CouponURLs\Original\Cache;

use CouponURLs\Original\Collections\Collection;

Abstract Class Cache
{
    protected $data;

    abstract public function get($key);
    abstract public function getIfExists($key); #: CacheValueResolver

    public function __construct($initialValues = [])
    {
        $this->initialValues = $initialValues;
        $this->reset();
    }
    
    public function reset()
    {
        $this->data = new Collection($this->initialValues);   
    }
    
}