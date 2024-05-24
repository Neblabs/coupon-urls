<?php

namespace CouponURLs\Original\Data\Drivers\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Data\WP_QueryFactory;
use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Data\Query\WordPressPostQueryParameters;
use WP_Post;

use function CouponURLs\Original\Utilities\Collection\_;

class WordPressPostReadableDriver implements ReadableDriver
{
    public function __construct(
        protected WP_QueryFactory $WP_QueryFactory,
    ) {}

    /**
     * If we needed to return an array instead, we could write a Decorator driver that takes
     * this class as a constructor parameter and uses this method to get the data and convert it 
     * to an array. 
     */
    /** @param WordPressPostQueryParameters $parameters */
    public function findOne(Parameters $parameters): WP_Post
    {
        $parameters->setLimitTo(1);

        (object) $posts = $this->findMany($parameters);

        return $posts->first();
    } 

    /** @return Collection<WP_Post> */
    public function findMany(Parameters $parameters): Collection
    {
        (object) $posts = $this->WP_QueryFactory->createWithArguments($parameters->query());

        return _($posts->posts);
    } 


    /**
     * todo: Maybe this could be improved in the future so that not all posts are loaded
     * in memory, instead we should be returing a count directly from the database;
     * in other words, it's the database that shuodl perform the count, not PHP.
     *
     * But since we need an MVP, we'll leave it like this FOR NOW.
     */
    public function has(Parameters $parameters): bool
    {
        return $this->findMany($parameters)->haveAny();
    } 

    //same as above
    public function count(Parameters $parameters): int
    {
        return $this->findMany($parameters)->count();
    } 
}