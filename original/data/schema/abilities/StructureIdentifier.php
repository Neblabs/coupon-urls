<?php

namespace CouponURLs\Original\Data\Schema\Abilities;

use CouponURLs\Original\Characters\StringManager;

/**
 * Example:
 * for a database table, it's the database name
 * for a file, it's the file,
 * etc
 */
interface StructureIdentifier
{
    public function get() : StringManager; 
}