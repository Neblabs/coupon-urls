<?php

namespace CouponURLs\Original\Cache;

use AllowDynamicProperties;
use CouponURLs\Original\Collections\Collection;

#[AllowDynamicProperties]
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