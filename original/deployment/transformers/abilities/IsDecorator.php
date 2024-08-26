<?php

namespace CouponURLS\Original\Deployment\Transformers\Abilities;

use CouponURLS\Original\Characters\StringManager;

interface IsDecorator
{
    public function decorated() : Transformable; 
}