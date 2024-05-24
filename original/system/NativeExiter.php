<?php

namespace CouponURLs\Original\System;

use CouponURLs\Original\System\Abilities\Exitable;

class NativeExiter implements Exitable
{
    public function exit(): void
    {
        exit;
    } 
}