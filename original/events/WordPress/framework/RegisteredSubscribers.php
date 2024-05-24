<?php

namespace CouponURLs\Original\Events\Wordpress\Framework;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\GettableCollectionDecorator;

use function CouponURLs\Original\Utilities\Collection\_;

class RegisteredSubscribers implements GettableCollection
{
    public function __construct(
        protected Collection /*<GettableCollection>*/ $subscriberGetters
        //protected FileSubscribersGetter $originalSubscribersGetter,
        //protected FileSubscribersGetter $appSubscribersGetter
    ) {}
    
    public function get(): Collection
    {
        (object) $subscribers = _();

        $this->subscriberGetters->forEvery(
            fn(GettableCollection $subscriberGetter) => $subscribers->append(
                $subscriberGetter->get()->ungroup()
            )
        );

        return $subscribers->group();
        ////---------------------------------------------
        ///
        ///
        ///-------------------------
        (object) $originalSubscribers = $this->originalSubscribersGetter->get();
        (object) $appSubscribers = $this->appSubscribersGetter->get();

        return $originalSubscribers->ungroup()
                                   ->append($appSubscribers->ungroup())
                                   ->group();
    } 
}