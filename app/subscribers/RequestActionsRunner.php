<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Domain\Actions\ActionsComposite;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Parts\WillAlwaysExecute;
use CouponURLs\Original\Events\Subscriber;

Class RequestActionsRunner implements Subscriber
{
    use DefaultPriority;
    use WillAlwaysExecute;
    use EmptyCustomArguments;

    public function __construct(
        protected ActionsComposite $actionsRunner
    ) {}

    public function execute() : void
    {
        $this->actionsRunner->perform();
    }
} 

