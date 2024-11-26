<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Data\Finders\Couponurls\CouponURLsFinder;
use CouponURLs\App\Domain\Actions\ActionsComposite;
use CouponURLs\App\Domain\CouponURLs\CouponURL;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Events\OptionalRegisterableSubscriber;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use WC_Cart;

use function CouponURLs\Original\Utilities\Collection\_;

Class ActionsRegistratorForCurrentURL implements Subscriber, OptionalRegisterableSubscriber
{
    static public function canBeRegistered() : Validator
    {
        return new Validators([
            new ValidWhen(defined('REST_REQUEST')? !REST_REQUEST : true),
            new ValidWhen(wc()->cart instanceof WC_Cart),
        ]);
    }

    public function priority(): int
    {
        return 6;
    } 

    public function __construct(
        protected CouponURLsFinder $couponURLsFinder,
        protected ActionsComposite $actions,
        protected URI $requestURI
    ) {}
    
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(_(
            couponURLForThisRequest: $this->couponURLsFinder->matchingURI($this->requestURI)->findThem()->asCollection()->first()
        ));
    }

    public function validator(?CouponURL $couponURLForThisRequest = null) : Validator
    {
        return new Validators([
            new ValidWhen($couponURLForThisRequest instanceof CouponURL),
            new ValidWhen(fn() => $couponURLForThisRequest->canRunActions())
        ]);
    }

    public function execute(CouponURL $couponURLForThisRequest) : void
    {
        $couponURLForThisRequest->actions->forEvery($this->actions->add(...));
    }
} 

