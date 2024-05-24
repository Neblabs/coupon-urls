<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Domain\Posts\Post;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;

use function CouponURLs\Original\Utilities\Text\i;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class WordpressPostMetaSaverFromDataProvider extends WordPressPostSaver
{
    public function __construct(
        protected WordPressPostMetaSaverDataProvider $dataProvider,
        protected GlobalFunctionWrapper $globalFunctionWrapper = new GlobalFunctionWrapper
    ) {}

    public function setPost(Post $post): void
    {
        parent::setPost($post);
        $this->dataProvider->setPost($post);

    }     
    public function canBeSaved(Collection $data): Validators
    {
        return new Validators([
            new ValidWhen($data->valueIsNotNull(key: $this->dataProvider->inputKey())),
            new ValidWhen(
                fn() => $this->dataProvider
                             ->canBeSaved(i($data->get($this->dataProvider->inputKey())))
                             ->isValid()
            )
        ]);
    } 

    public function save(Collection $data)
    {
        /*string|Collection*/ $itemsToSave = $this->dataProvider->dataToSave(
            i($data->get($this->dataProvider->inputKey()))
        );
        #We're not using update_post_meta for when a provider has several values
        $this->globalFunctionWrapper->delete_post_meta(
            post_id: $this->post->id(),
            meta_key: $this->dataProvider->outputKey()
        );

        foreach (_($itemsToSave) as $dataToSave) {
            $this->globalFunctionWrapper->add_post_meta(
                post_id: $this->post->id(),
                meta_key: $this->dataProvider->outputKey(),
                meta_value: $dataToSave,
                unique: false
            );
        }
    } 
}