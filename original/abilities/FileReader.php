<?php

namespace CouponURLs\Original\Abilities;

interface FileReader
{
    public function read(ReadableFile $readableFile) : mixed;
}