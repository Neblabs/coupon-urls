<?php

namespace CouponURLs\App\Credentials;

use CouponURLs\Original\Data\Schema\DatabaseCredentials;

/*
    ONLY USED IN DEVELOPMENT, IGNORED IN PRODUCTION    
*/
Class ConsoleCredentials extends DatabaseCredentials
{
    protected function set()
    {
        return [
            'name' => 'couponsplus_intergation_testing_facility',
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => ''
        ];
    }
}