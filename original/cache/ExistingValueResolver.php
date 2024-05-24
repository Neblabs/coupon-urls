<?php

namespace CouponURLs\Original\Cache;

use Closure;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Utilities\TypeChecker;
use CouponURLs\Original\Characters\StringManager;

Class ExistingValueResolver
{
    use TypeChecker;

    protected $key;
    protected $data;

    public function __construct(array $keyAndData)
    {
        $this->key = new StringManager($keyAndData['key']);
        $this->data = $keyAndData['data'];
    }

    public function otherwise($returnValue)
    {
        if ($this->data->hasKey($this->key)) {
            return $this->data->get($this->key);
        }

        $value = ($returnValue instanceof Closure)? $this->call($returnValue) : $returnValue;

        $this->data->add($this->key, $value);
        
        return $value;       
    }

    public function call(Callable $returnValue)
    {
        return $returnValue();
    }
    
}