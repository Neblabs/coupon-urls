<?php

namespace CouponURLs\Original\Core\Abilities;

interface Service
{
    public function id() : string;
    public function start(ServicesContainer $servicesContainer) : void;
    public function stop(ServicesContainer $servicesContainer) : void;
}