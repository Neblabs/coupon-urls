<?php

namespace CouponURLs\Original\Collections;

Class Stopper
{
    protected $shouldStop = false;

    public function __invoke(...$arguments)
    {
        return $this->stop(...$arguments);   
    }
    
    public function stop($value = null)
    {
        $this->shouldStop = true;

        return $value;
    }
    
    public function shouldStop() : bool
    {
        return $this->shouldStop;   
    }
}
