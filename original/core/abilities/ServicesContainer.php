<?php

namespace CouponURLs\Original\Core\Abilities;

use CouponURLs\Original\Core\Services;
use Throwable;

interface ServicesContainer
{
    public function addService(Service $service) : void;
    
    public function runningServices() : Services;
    public function queuedServices() : Services; 
    
    public function onServiceStart(Service $service) : void; 
    public function onServiceStop(Service $service) : void; 
    public function onServiceException(Service $service, Throwable $exception) : void;
}