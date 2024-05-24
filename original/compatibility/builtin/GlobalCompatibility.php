<?php

namespace CouponURLs\Original\Compatibility\BuiltIn;

use CouponURLs\Original\Compatibility\CompatibilityManager;

/**
 * gets executed everytime, regardless of the plugins installed. A "chocolate" CompatibilityManager
 */
Class GlobalCompatibility extends CompatibilityManager
{
    /**
     * Will always run regardless of what other CompatibilityManagers have declared
     * @param  boolean $shouldDefaultBeHandled
     * @return boolean
     */
    final public function shouldHandle($shouldDefaultBeHandled = true)
    {
        return true;   
    }

    public function shouldDefaultBeHandled($defaultShouldRun = true)
    {
        return $defaultShouldRun;
    }
}