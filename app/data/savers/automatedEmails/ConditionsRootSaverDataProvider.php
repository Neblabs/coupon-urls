<?php

namespace CouponURLs\App\Data\Savers\Automatedemails;

use CouponURLs\App\Data\Finders\ConditionsRoot\ConditionsRootStructure;
use CouponURLs\App\Data\Finders\Events\EventStructure;
use CouponURLs\App\Data\Savers\WordPressPostMetaSaverDataProvider;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

class ConditionsRootSaverDataProvider extends WordPressPostMetaSaverDataProvider
{
    public function __construct(
        protected ConditionsRootStructure $conditionsRootStructure
    ) {}
    
    public function inputKey(): string
    {
        return Env::idLowerCase().'-conditions_root';
    } 

    public function outputKey(): string
    {
        return $this->conditionsRootStructure->fields()->id()->id();
    } 

    public function canBeSaved(StringManager $dataToSave): Validator
    {
        // obly if valid json
        return new PassingValidator;
    } 

    public function dataToSave(StringManager $dataToSave): Collection|string|int|float
    {
        return sanitize_text_field(wp_unslash($dataToSave->get()));       
    } 
}