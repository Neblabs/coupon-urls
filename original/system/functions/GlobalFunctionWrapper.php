<?php

namespace CouponURLs\Original\System\Functions;

/**
 * This class is used on development environments only.
 *
 *  It allows us to mock (mainly) the WordPress global functions so
 *  that we can unit test all our code easily.
 *
 * After development, when building the production version of this plugin,
 * we replace all calls to this class with nothing so as to make it call a global fucntion.
 *
 * For example:
 *     We replaced:
 *     $this->globalFunctionWrapper->add_action(hook_name: 'myhook', callback: $this->execute(...), accepted_args: 5)
 *         with:
 *     add_action(hook_name: 'myhook', callback: $this->execute(...), accepted_args: 5)
 *
 * So that Rector can then identify the add_action function correclty and replace the named arguments 
 * to make the code compatible with versions older then php 8.
 *
 * Unfortunately we cannot remove all references to this class entirely from the production builds 
 * since it's a much more complex thing to do and more prone
 * to produce bugs and syntax errors. So in the places where you see this class just sitting there without doing anything,
 * it actually did a lot and it's not there by mistake.
 */
Class GlobalFunctionWrapper
{
    public function __call($name, $arguments) : mixed
    {
        return $name(...$arguments);
    }
}