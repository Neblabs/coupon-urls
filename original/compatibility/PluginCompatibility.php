<?php

namespace CouponURLs\Original\Compatibility;

use CouponURLs\Original\Compatibility\BuiltIn\GlobalCompatibility;
use CouponURLs\Original\Compatibility\CompatibilityManager;
use CouponURLs\Original\Utilities\TypeChecker;

/**
 * GlobalCompatibility will *always* run 
 * DefaultCompatibilty will only run when no other CompatibiltyManagers have run (excluding GlobalCompatibility).
 */
Class PluginCompatibility
{
    use TypeChecker;

    public static function handle(array $compatibilityManagers)
    {
        (boolean) $defaultShouldRun = true;

        foreach ($compatibilityManagers as $compatibilityManager) {
            $compatibilityManager = static::expectValue($compatibilityManager)->toBe(CompatibilityManager::class);

            if (($compatibilityManager instanceof GlobalCompatibility) || 
                $compatibilityManager->shouldHandle($defaultShouldRun)) {

                $defaultShouldRun = $compatibilityManager->shouldDefaultBeHandled($defaultShouldRun);
                $compatibilityManager->handle();
            }
        }
    }
    
}