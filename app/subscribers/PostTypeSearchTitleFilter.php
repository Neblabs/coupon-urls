<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

use function CouponURLs\Original\Utilities\Collection\_;

Class PostTypeSearchTitleFilter implements Subscriber
{
    use DefaultPriority;
    use EmptyCustomArguments;

    public function validator() : Validator
    {
        return new PassingValidator;
    }

    public function execute() : void
    {
        add_filter('wp_link_query', function(array /*<array>*/ $results) : array {
            return _($results)->map(
                function(array $postData) : array {
                    $postData = _($postData);
                    (string) $postType = get_post_type($postData->get('ID'));

                    return $postData->set('title', "{$postData->get('title')} ($postType) (#{$postData->get('ID')})")->asArray();
                }
            )->asArray();
        });
    }
} 

