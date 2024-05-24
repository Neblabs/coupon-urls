<?php

namespace CouponURLs\App\Build\Scripts;

use CouponURLs\App\Handlers\DashboardScriptsHandler;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Deployment\Script;
use CouponURLs\Original\Environment\Env;

Class TranslationFilesMerger extends Script
{
    public function run()
    {
        print 'mergin translations, please dont quit...';

        $this->addMainFileFile();
        $this->addScriptsFile();

        print 'translations done!';
   }

   protected function addMainFileFile()
   {
        file_put_contents(
            $this->getProductionFileName(), 
            file_get_contents(Env::directory().Env::settings()->app->translationFiles->main)
        );
   }

   protected function addScriptsFile()
   {

        (string) $scriptsFileContents = file_get_contents(Env::directory().Env::settings()->app->translationFiles->scripts);
        (string) $onlyTheTranslatableStrings = (
            substr(
                $scriptsFileContents, 
                strpos($scriptsFileContents, '#:')
            )
        );
        (object) $assetsData = DashboardScriptsHandler::getAssetsdata();
        (string) $buildFilepath = "app/scripts/dashboard/build{$assetsData->get('files')->{'main.js'}}:2";
        (string) $withBuildSource = preg_replace('/#:.+/', "#: {$buildFilepath}", $onlyTheTranslatableStrings);
        $matches = [];
        file_put_contents(
            $this->getProductionFileName(), 
            "\n{$withBuildSource}",
            FILE_APPEND
        );
   }

   protected function getProductionFileName() : string
   {
       return Env::settings()->app->translationFiles->production;   
   }
}