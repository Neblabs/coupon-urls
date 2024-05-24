<?php

namespace CouponURLs\Original\Data\Drivers\Wordpress;

use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;

class WordPressOptionsReadableDriver implements ReadableDriver
{
    public function has(Parameters $parameters): bool
    {
        (string) $placeholderForNonExistingOption = '__NULL__';

        return get_option(
            option: $parameters->find(),
            default: $placeholderForNonExistingOption
        ) !== $placeholderForNonExistingOption;
    } 

    public function find(Parameters $parameters): mixed
    {
        return get_option(
            option: $parameters->get()
        );        
    } 
}