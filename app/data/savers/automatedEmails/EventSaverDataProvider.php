<?php

namespace CouponURLs\App\Data\Savers\Automatedemails;

use CouponURLs\App\Data\Finders\Events\EventStructure;
use CouponURLs\App\Data\Savers\WordPressPostMetaSaverDataProvider;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

class EventSaverDataProvider extends WordPressPostMetaSaverDataProvider
{
    public function __construct(
        protected EventStructure $eventStructure
    ) {}
    
    public function inputKey(): string
    {
        return Env::idLowerCase().'-event';
    } 

    public function outputKey(): string
    {
        return $this->eventStructure->fields()->id()->id();
    } 

    public function canBeSaved(StringManager $dataToSave): Validator
    {
        //check that the event actually exists
        return new PassingValidator;
    } 

    public function dataToSave(StringManager $dataToSave): Collection|string|int|float
    {
        return sanitize_text_field(wp_unslash($dataToSave->get()));       
    } 
}