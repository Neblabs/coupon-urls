<?php

namespace CouponURLs\Original\Installation;

use CouponURLs\Original\Environment\Env;

Class InstallEvent
{
    const HAS_RUN = 1;
    const HAS_NOT_RUN = 0;

    public function __construct(Installation $installation)
    {
        $this->installation = $installation;
    }

    public function runOnce() 
    {
        register_activation_hook(
            Env::absolutePluginFilePath(), 
            [$this, 'activateOnce']
        );   
    }

    public function activateOnce()
    {
        if (!$this->hasRun()) {
            $this->updateHasRunToTrue();
            $this->installation->install();
        }
    }

    protected function hasRun() : bool
    {
        return (integer) get_option(
            $name = $this->getHasRunOptionName(), 
            $default = static::HAS_NOT_RUN
        ) === static::HAS_RUN;
    }
    
    protected function updateHasRunToTrue()
    {
        update_option(
            $name = $this->getHasRunOptionName(), 
            $value = static::HAS_RUN
        );
    }

    protected function getHasRunOptionName() : string
    {
        return Env::getwithShortPrefix('plugin_installation_has_run');
    }
    
}