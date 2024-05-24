<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Redirections\Redirection;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Redirections\CartURL;
use CouponURLs\App\Domain\Redirections\CheckoutURL;
use CouponURLs\App\Domain\Redirections\HomePageURL;
use CouponURLs\App\Domain\Redirections\PlainURL;
use CouponURLs\App\Domain\Redirections\PostTypeRedirectionValidator;
use CouponURLs\App\Domain\Redirections\PostTypeURL;
use CouponURLs\App\Domain\Redirections\RelativeURL;
use CouponURLs\App\Domain\Redirections\ShopURL;
use CouponURLs\App\Domain\Redirections\WordPressURLRedirector;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;
use CouponURLs\Original\System\NativeExiter;
use CouponURLs\Original\Validation\Validators\PassingValidator;

use function CouponURLs\Original\Utilities\Collection\_;

class RedirectionFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    public function __construct(
        protected Cart $cart,
    ) {}
    
    public function create(Coupon $coupon, MappedObject $options): Redirection
    {
        /**
         * This should have been extracted into their own factories but
         * we're running out of time, so this will have to be a compromise
         */
        /*object*/ $redirectionObjects = match($options->type->get()) {
            'cart' => $this->createCartRedirectionObjects($options),
            'checkout' => $this->createCheckoutRedirectionObjects($options),
            'shop' => $this->createShopRedirectionObjects($options),
            'postType' => $this->createPostTypeRedirectionObjects($options),
            'homepage' => $this->createHomePageRedirectionObjects($options),
            'path' => $this->createRelativeURLRedirectionObjects($options),
            'url' => $this->createURLRedirectionObjects($options)
        };

        return new Redirection(
            new WordPressURLRedirector(
                ...[
                    ...$redirectionObjects->getValues()->asArray(),
                    ...[new NativeExiter]
                ],
            )
        );
    } 

    protected function createCartRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new CartURL,
            redirectionValidator: new PassingValidator,
        );
    }

    protected function createCheckoutRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new CheckoutURL,
            redirectionValidator: new passingValidator,
        );
    }

    protected function createShopRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new ShopURL,
            redirectionValidator: new passingValidator,
        );
    }

    protected function createPostTypeRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new PostTypeURL((integer) $options->value->get()),
            redirectionValidator: new PostTypeRedirectionValidator((integer) $options->value->get()),
        );
    }

    protected function createHomePageRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new HomePageURL($options->value),
            redirectionValidator: new PassingValidator,
        );
    }

    protected function createRelativeURLRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new RelativeURL($options->value),
            redirectionValidator: new PassingValidator,
        );
    }

    protected function createURLRedirectionObjects(MappedObject $options) : Collection
    {
        return _(
            url: new PlainURL($options->value),
            redirectionValidator: new PassingValidator,
        );
    }
    
}