<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Creation\Actions\ActionsFactory;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use function CouponURLs\Original\Utilities\Collection\_;

Class TestDependenciesExposer implements Subscriber
{
    use DefaultPriority;
    use EmptyCustomArguments;

    public function __construct(
        protected ActionsFactory $actionsFactory,
        protected Cart $cart,
        protected CouponsToBeAdded $couponsToBeAdded
    ) {}
    
    public function validator() : Validator
    {
        return new ValidWhen(Env::settings()->environment !== 'production');
    }

    public function execute() : void
    {
        add_filter(hook_name: 'ActionsFactory', callback: fn() => $this->actionsFactory);
        add_filter(hook_name: 'Cart', callback: fn() => $this->cart);
        add_filter(hook_name: 'CouponsToBeAdded', callback: fn() => $this->couponsToBeAdded);
    }
} 

