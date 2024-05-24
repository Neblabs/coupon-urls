<?php

namespace CouponURLs\App\Data\Savers\Automatedemails;

use CouponURLs\App\Data\Finders\Recipients\RecipientStructure;
use CouponURLs\App\Data\Savers\WordPressPostMetaSaverDataProvider;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

use function CouponURLs\Original\Utilities\Collection\_;

class RecipientsSaverDataProvider extends WordPressPostMetaSaverDataProvider
{
    public function __construct(
        protected RecipientStructure $recipientStructure
    ) {}
    
    public function inputKey(): string
    {
        return Env::idLowerCase().'-recipients';
    } 

    public function outputKey(): string
    {
        return $this->recipientStructure->fields()->id()->id();
    } 

    public function canBeSaved(StringManager $dataToSave): Validator
    {
        return new PassingValidator;
    } 

    public function dataToSave(StringManager $dataToSave): Collection|string|int|float
    {
        return _(json_decode(wp_unslash($dataToSave->get())))->map(
            fn(string $email) => _(email: sanitize_text_field($email))->asJson()->get()
        );       
    } 
}