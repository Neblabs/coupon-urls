<?php

namespace CouponURLs\Original\Compatibility\BuiltIn;

use CouponURLs\Original\Compatibility\CompatibilityManager;

Class DefaultCompatibilty extends CompatibilityManager
{
    /**
     * If some other CompatibilityManager has previously declared the default shouldn't run, 
     * then we don't run it.
     * @param  boolean $shouldDefaultBeHandled
     * @return boolean
     */
    public function shouldHandle($shouldDefaultBeHandled = true)
    {
        return $shouldDefaultBeHandled;   
    }

    /**
     * We'll allow more than one DefaultCompatibilty object to be run
     * @param  boolean $defaultShouldRun 
     * @return boolean
     */
    public function shouldDefaultBeHandled($defaultShouldRun = true)
    {
        return true;
    }
}