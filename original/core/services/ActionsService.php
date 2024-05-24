<?php

namespace CouponURLs\Original\Core\Services;

use CouponURLs\Original\Core\Abilities\Service;
use CouponURLs\Original\Core\Abilities\ServicesContainer;
use CouponURLs\Original\Events\Wordpress\Hooks;

class ActionsService implements Service
{
    public function id(): string
    {
        return 'actions';
    } 

    public function start(ServicesContainer $servicesContainer): void
    {
        (object) $actions = $this->registeredActions($servicesContainer);

        $actions->register();
    } 

    public function stop(ServicesContainer $servicesContainer): void
    {
        (object) $actions = $this->registeredActions($servicesContainer);

        $actions->unregister();
    } 

    protected function registeredActions(ServicesContainer $servicesContainer) : Hooks
    {
        /** @var DependenciesService */
        (object) $dependenciesService = $servicesContainer->runningServices()->get('dependencies');
        (object) $dependenciesContainer = $dependenciesService->container();

        return $dependenciesContainer->get(Hooks::class);
    }
    
}