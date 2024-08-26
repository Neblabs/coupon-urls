<?php

namespace CouponURLS\Original\Deployment\Scripts;

use CouponURLS\Original\Construction\Core\ProductionServiceExceptionHandlerFactory;
use CouponURLS\Original\Core\Exceptions\Handlers\OriginalServiceExceptionHandlerFactoryTypes;
use CouponURLS\Original\Deployment\Script;
use CouponURLS\Original\Environment\Env;
use Exception;
use function CouponURLS\Original\Utilities\Text\i;

Class DevelopmentServiceExceptionHandlerFactoryRemoverScript extends Script
{
    public function run()
    {
        (string) $copyDirectoryName = $this->data->get('copyDirectoryName');

        (object) $file = new OriginalServiceExceptionHandlerFactoryTypes;
        (object) $originalFilePath = i($file->source());
        (object) $targetFilePath = $originalFilePath->replace(
            search: Env::originalDirectory(), 
            replacement: "{$copyDirectoryName}/original"
        );

        //dump($copyDirectoryName, $originalFilePath->get(), $targetFilePath->get());

        if (!file_exists($targetFilePath->get())) {
            throw new Exception('file not found');
        }

        file_put_contents(
            $targetFilePath, 
            data: ("<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly\n\nreturn ".var_export([ProductionServiceExceptionHandlerFactory::class], return: true).';')
        );
    }
    
}