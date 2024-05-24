<?php

namespace CouponURLs\Original\Core;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Core\Abilities\Service;
use CouponURLs\Original\Core\Abilities\ServicesContainer;
use Throwable;

use function CouponURLs\Original\Utilities\Collection\_;

class Services
{
    protected Collection $services;

    public function __construct()
    {
        $this->services = _();
    }

    public function start(ServicesContainer $servicesContainer) : void
    {
        foreach ($this->services->asArray() as $service) {
            try {
                $this->startService($service, $servicesContainer);
            } catch (Throwable $exception) {
                $servicesContainer->onServiceException($service, $exception);
            }
        }
    }

    protected function startService(Service $service, ServicesContainer $servicesContainer) : void
    {
        $service->start($servicesContainer);
        $servicesContainer->onServiceStart($service);
    }

    public function stop(ServicesContainer $servicesContainer) : void
    {
        //lets run from the last to the first
        foreach ($this->services->invert()->asArray() as $service) {
            try {
                $this->stopService($service, $servicesContainer);
            } catch (Throwable $exception) {
                $servicesContainer->onServiceException($service, $exception);
            }
        }
    }

    protected function stopService(Service $service, ServicesContainer $servicesContainer) : void
    {
        $service->stop($servicesContainer);
        $servicesContainer->onServiceStop($service);
    }
    
    public function add(Service $service) : void
    {
        $this->services->push($service);
    }

    public function prepend(Service $service) : void
    {
        $this->services->pushAtTheBeginning($service);
    }

    public function remove(Service $serviceToRemove) : void
    {
        $this->services = $this->services->filter(
            fn(Service $service) => $serviceToRemove !== $service
        );
    }

    public function has(string $id) : bool
    {
        return $this->services->have(
            fn(Service $service) => $service->id() === $id
        );
    }

    public function count() : int
    {
        return $this->services->count();
    }

    public function haveAny() : bool
    {
        return $this->services->haveAny();
    }

    /**
     * @throws Throwable
     */
    public function get(string $id) : Service
    {
        return $this->services->find(
            fn(Service $service) => $service->id() == $id
        );
    }
}