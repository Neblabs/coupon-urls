<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Components;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use Symfony\Component\HttpFoundation\Request;
use WP_Post;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;

Class CouponURLsDataSaver implements Subscriber
{
    use DefaultPriority;

    public function __construct(
        protected Components $actionComponents
    ) {}
    
    public function createEventArguments(int $postId, WP_Post $post) : EventArguments
    {
        return new EventArguments(_(
            post: $post,
            /**
             * Note: The nonce is verified in the method bellow self::validator()
             */
            requestData: _(Request::createFromGlobals()->request->all())
        ));
    }

    public function validator(WP_Post $post, Collection $requestData) : Validator
    {
        return new Validators([
            new ValidWhen($post->post_type === 'shop_coupon'),
            new ValidWhen(fn() => ((boolean) wp_verify_nonce(
                sanitize_text_field(wp_unslash($requestData->get(Env::getWithPrefix('dashboard_nonce')))), 
                Env::getWithPrefix('dashboard_nonce')
            )))
        ]);
    }

    public function execute(WP_Post $post, Collection $requestData) : void
    {
        /**
         * This is a very quick & dirty (but safe!) way to save the data.
         * This needs a rewrite though cause having all of this in the same place
         * is not good.
         */
        (object) $state = i(sanitize_text_field(wp_unslash($requestData->get('coupon_urls_state'))))->import();

        update_post_meta(
            post_id: $post->ID,
            meta_key: Env::getWithPrefix('options'),
            meta_value: wp_json_encode($state->options)
        );

        // dont save it since the user may not have entered any data!
        if (!$state->options['isEnabled']) {
            return;
        }


        (object) $queryParameters = _($state->queryParameters)->map(
            fn(array $parameter) => i("{$parameter['key']}={$parameter['value']}")->trim()->removeRight('=')
        )->implode('&');
        (string) $uri = "{$state->uri['type']}|{$state->uri['value']}";
        (object) $actions = _($state->actions ?? []);


        update_post_meta(
            post_id: $post->ID,
            meta_key: Env::getWithPrefix('query'),
            meta_value: (string) $queryParameters
        );

        update_post_meta(
            post_id: $post->ID,
            meta_key: Env::getWithPrefix('uri'),
            meta_value: (string) $uri
        );

        $this->actionComponents->all()->forEvery(fn(Identifiable $actionComponent) => delete_post_meta(
            post_id: $post->ID,
            meta_key: Env::getWithPrefix("action_{$actionComponent->identifier()}")
        ));

        $actions = $this->sortActions($actions);

        $actions->forEvery(fn(array $action) => update_post_meta(
            post_id: $post->ID,
            meta_key: Env::getWithPrefix("action_{$action['type']}"),
            meta_value: _($action['options'] ?? [])->asJson()->get()
        ));
    }

    protected function sortActions(Collection $actions) : Collection
    {
        (object) $sortedActions = _();
        (object) $find = fn(string $actionType) => fn(array $action) => $action['type'] === $actionType;
        (object) $findNot = fn(string $actionType) => fn(array $action) => $action['type'] !== $actionType;

        (array) $correctOrder = [
            'AddProduct',
            'AddCoupon',
            'CouponToBeAddedNotificationMessage',
            'CouponAddedToCartExtraNotificationMessage',
            'Redirection'
        ];
        
        foreach ($correctOrder as $actionType) {
            if ($actions->have($find($actionType))) {
                $sortedActions->push($actions->find($find($actionType)));
                $actions->filter($findNot($actionType));
            }
        }

        return $sortedActions;
    }
    
} 

