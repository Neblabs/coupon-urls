<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Components\Components;
use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\CouponURLs\CouponURL;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Environment\Env;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

class ActionsFactory implements CreatableFromCouponUrl 
{
    public function __construct(
        protected Components $actionComponents,
        protected FactoryOverloader $actionsFactoryOverloader,
        protected OptionsFromTemplateAndOptionableFactory $optionsFromTemplateAndOptionableFactory
    ) {}
    
    public function createFromCoupon(Coupon $coupon): Collection
    {
        (object) $couponUrlData = _(get_post_meta($coupon->id()));
        (object) $actionTypes = [];

        (object) $onlyActionsData = fn(array $values, string $key) => i($key)->startsWith(Env::getWithPrefix('action'));
        (object) $onlyValidActions = fn(mixed $value, string $actionType) => $this->actionComponents->has($actionType);

        return $couponUrlData
            ->filter($onlyActionsData)
            ->mapWithKeys(
                fn(array $values, string $key) => a(
                    key: i($key)->replace(Env::getWithPrefix('action_'), '')->get(),
                    value: $values[0]
                )
            )
            ->filter($onlyValidActions)
            ->map(fn(string|int|null|bool $options, string $actionType) => $this->createFromType($actionType, $options, $coupon));
    } 

    public function createFromType(string $actionType, string $options, Coupon $coupon) : Actionable
    {
        /** @var ActionFromCouponAndMappedObjectFactory */
        (object) $actionFactory = $this->actionsFactoryOverloader->overload($actionType);

        return $actionFactory->create(
            $coupon, 
            $this->optionsFromTemplateAndOptionableFactory->create(
                $options, 
                $this->actionComponents->withId($actionType)
            )
        );
    }
}