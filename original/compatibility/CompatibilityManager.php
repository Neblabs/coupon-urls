<?php

namespace CouponURLs\Original\Compatibility;

Abstract Class CompatibilityManager
{
    protected $handler;

    abstract public function shouldHandle($shouldDefaultBeHandled = true); #: boolean

    public function __construct(callable $handler)
    {
        $this->handler = $handler;   
    }
    
    public function shouldDefaultBeHandled($defaultShouldRun = true)
    {
        return false;
    }

    public function handle()
    {
        call_user_func($this->handler);
    }
}