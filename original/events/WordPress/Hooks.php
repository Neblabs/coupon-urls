<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;

class Hooks
{
    public function __construct(
        protected Collection $hooks
    ) {}
    
    public function register() : void
    {   
    //the old forEvery method is left for the typehinting of 'Hook', will remove when we get generics
        $this->hooks->forEvery(fn(Hook $hook) => $hook->register());
    }

    public function unregister() : void
    {
        $this->hooks->perform(unregister: null);
    } 
}