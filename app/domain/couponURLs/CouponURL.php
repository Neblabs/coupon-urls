<?php

namespace CouponURLs\App\Domain\CouponURLs;

use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Domain\Entity;

Class CouponURL extends Entity
{
    public readonly Collection /*<Actionable>*/ $actions;
    public readonly URI $URI;

    protected readonly MappedObject $options;

    public function __construct(
        public readonly Coupon $coupon,
    ) {}

    public function setActions(Collection/*<Actionable>*/ $actions) : void
    {
        $this->actions = $actions;
    }

    public function setOptions(MappedObject $options): void
    {
        $this->options = $options;    
    } 

    public function setURI(URI $URI) : void
    {
        $this->URI = $URI;
    }

    public function canRunActions() : bool
    {
        return $this->actions->haveAny() && $this->options->isEnabled;
    }
}