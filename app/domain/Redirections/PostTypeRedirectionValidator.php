<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use Exception;

use function CouponURLs\Original\Utilities\Text\i;

class PostTypeRedirectionValidator extends Validator
{
    public function __construct(
        protected int $postTypeId,
        protected GlobalFunctionWrapper $_ = new GlobalFunctionWrapper
    ) {}
    
    public function execute(): ValidationResult
    {
        return $this
        //post exists
        ->passWhen((boolean) $this->_->get_post(post: $this->postTypeId));
        //todo: the url for that post is not the current url
    } 

    protected function getDefaultException(): Exception
    {
        return new Exception('post type validation failed!');
    } 
}