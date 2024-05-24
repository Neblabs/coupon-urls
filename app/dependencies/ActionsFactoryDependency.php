<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Components\Actions\Builtin\AddCouponComponent;
use CouponURLs\App\Components\Actions\Builtin\AddProductComponent;
use CouponURLs\App\Components\Components;
use CouponURLs\App\Creation\Actions\ActionsFactory;
use CouponURLs\App\Creation\Actions\AddCouponFactory;
use CouponURLs\App\Creation\Actions\AddProductFactory;
use CouponURLs\App\Creation\Actions\CouponAddedToCartExtraNotificationMessageFactory;
use CouponURLs\App\Creation\Actions\CouponToBeAddedNotificationMessageFactory;
use CouponURLs\App\Creation\Actions\OverloadableFactoryById;
use CouponURLs\App\Creation\Actions\RedirectionFactory;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use function CouponURLs\Original\Utilities\Collection\_;

class ActionsFactoryDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected Components $actionComponents,
        protected AddCouponFactory $addCouponFactory,
        protected AddProductFactory $addProductFactory,
        protected RedirectionFactory $redirectionFactory,
        protected CouponAddedToCartExtraNotificationMessageFactory $couponAddedToCartExtraNotificationMessageFactory,
        protected CouponToBeAddedNotificationMessageFactory $couponToBeAddedNotificationMessageFactory
    ) {}
    
    static public function type(): string
    {
        return ActionsFactory::class;        
    } 

    public function create(): ActionsFactory
    {
        return new ActionsFactory(
            actionComponents: $this->actionComponents,
            actionsFactoryOverloader: new FactoryOverloader(_(
                new OverloadableFactoryById(
                    identifiable: $this->actionComponents->withId('AddCoupon'),
                    factoryWithVariableArguments: $this->addCouponFactory
                ),
                new OverloadableFactoryById(
                    identifiable: $this->actionComponents->withId('AddProduct'),
                    factoryWithVariableArguments: $this->addProductFactory
                ),
                new OverloadableFactoryById(
                    identifiable: $this->actionComponents->withId('Redirection'),
                    factoryWithVariableArguments: $this->redirectionFactory
                ),
                new OverloadableFactoryById(
                    identifiable: $this->actionComponents->withId('CouponToBeAddedNotificationMessage'),
                    factoryWithVariableArguments: $this->couponToBeAddedNotificationMessageFactory
                ),
                new OverloadableFactoryById(
                    identifiable: $this->actionComponents->withId('CouponAddedToCartExtraNotificationMessage'),
                    factoryWithVariableArguments: $this->couponAddedToCartExtraNotificationMessageFactory
                )
            )),
            optionsFromTemplateAndOptionableFactory: new OptionsFromTemplateAndOptionableFactory
        );
    } 
}