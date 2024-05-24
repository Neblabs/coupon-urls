<?php
namespace CouponURLs\App\Domain\Actions\Messages;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\App\Domain\Redirections\Abilities\Redirectable;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

Class CouponToBeAddedNotificationMessage implements Actionable, RestrictableAction
{
    public function __construct(
        protected string $message,
        protected CouponsToBeAdded $couponsToBeAdded,
        protected Coupon $coupon,
        protected GlobalFunctionWrapper $_ = new GlobalFunctionWrapper
    ) {}
    
    public function canPerform(): Validator
    {
        return new ValidWhen($this->couponsToBeAdded->hasAddedToTheQueue($this->coupon));
    } 

    public function perform(): void
    {
        $this->_->wc_add_notice(
            message: $this->message,
            notice_type: 'notice',
            data: [$this->coupon->code()->get()]
        );
    } 
}