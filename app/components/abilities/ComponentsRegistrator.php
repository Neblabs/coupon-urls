<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\App\Components\Components;
use CouponURLs\Original\Characters\StringManager;

interface ComponentsRegistrator
{
    public function id() : StringManager;

    public function canRegisterUsing(MultipleComponentsProvider $multipleComponentsProvider) : bool; 
    public function registerUsing(MultipleComponentsProvider $multipleComponentsProvider) : void;     

    public function components() : Components; 
}