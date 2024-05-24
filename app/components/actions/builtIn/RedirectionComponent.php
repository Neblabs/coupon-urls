<?php

namespace CouponURLs\App\Components\Actions\Builtin;

use CouponURLs\App\Components\Abilities\Descriptables;
use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\__;

class RedirectionComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier(): string
    {
        return 'Redirection';    
    } 

    public function name()/*: \Stringable*/ 
    {
        return __('Redirect');
    } 

    public function descriptions() : Collection
    {
        return _(
            __("This action will always be executed after all others"),
        );
    } 

    public function options() : Collection
    {
        return _(
            type: TYPES::STRING()->allowed([
                'cart', 'checkout', 'shop', 'homepage', 'postType', 'path', 'url'
            ])->meta(a(
                field: a(
                    labels: a(
                        top: __('To')
                    ),
                ),
                values: a(
                    a(value: 'cart', name: 'Cart', description: 'The WooCommerce Cart Page'),
                    a(value: 'checkout', name: 'Checkout', description: 'The WooCommerce Checkout Page'),
                    a(value: 'shop', name: 'Shop', description: 'The WooCommerce Main Shop Page'),
                    a(value: 'homepage', name: 'HomePage', description: "The site's Home Page"),
                    a(value: 'postType', name: 'Page', description: 'Any page (including posts, pages and products)'),
                    a(value: 'path', name: 'Custom Path', description: 'A relative path on this site (a path after your homepage url)'),
                    a(value: 'url', name: 'URL', description: 'Any URL'),
                )
            )),
            value: TYPES::STRING()->meta(a(
                dynamicFields: [
                    a(
                        when: a(field: 'type', operator: '==', value: 'path'),
                        field: a(
                            labels: a(
                                top: __('Path relative to the homepage')
                            ),
                            placeholder: __('/path/to/use/'),
                            width: 'full'
                        ),
                    ),
                    a(
                        when: a(field: 'type', operator: '==', value: 'url'),
                        field: a(
                            labels: a(top: __('URL to redirect to')),
                            placeholder: __('https://google.com'),
                            width: 'full'
                        ),
                    ),
                    a(
                        when: a(field: 'type', operator: '==', value: 'postType'),
                        field: a(
                            searchable: a(
                                url: esc_url(admin_url('admin-ajax.php')),
                                method: 'POST',
                                data: a(
                                    action: 'wp-link-ajax',
                                    _ajax_linking_nonce: esc_html(wp_create_nonce('internal-linking')),
                                    search: '((value))',
                                )
                            ),
                            labels: a(top: __('Page (post type) name')),
                            placeholder: __('Page name...'),
                            width: 'full'
                        ),
                    ),
                ]
            ))
        );
    }
}
