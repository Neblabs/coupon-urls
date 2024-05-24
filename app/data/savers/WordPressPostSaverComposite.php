<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;

class WordPressPostSaverComposite extends WordPressPostSaver
{
    public function __construct(
        protected Collection /*<WordPressPostSaver>*/ $wordpressPostSavers,
    ) {}
    
    public function save(Collection $data)
    {
        $this->wordpressPostSavers->perform(setPost: $this->post)
                                  ->filter(fn(WordPressPostSaver $wordPressPostSaver) => $wordPressPostSaver->canBeSaved($data)->isValid())
                                  ->perform(save: $data);
    } 

    public function canBeSaved(Collection $data): Validator
    {
        return new PassingValidator;
    } 
}