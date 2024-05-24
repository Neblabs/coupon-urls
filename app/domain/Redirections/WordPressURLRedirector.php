<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\Redirectable;
use CouponURLs\App\Domain\Redirections\Abilities\URL;
use CouponURLs\Original\System\Abilities\Exitable;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;

class WordPressURLRedirector implements Redirectable
{
    public function __construct(
        protected URL $url,
        protected Validator $redirectionValidator,
        protected Exitable $exiter,
        protected GlobalFunctionWrapper $_ = new GlobalFunctionWrapper
    ) {}
    
    public function canRedirect(): bool
    {
        return $this->redirectionValidator->isValid();
    } 

    public function redirect(): void
    {
        $this->_->wp_redirect(location: esc_url($this->url->get())) && 
        $this->exiter->exit();
    } 
}