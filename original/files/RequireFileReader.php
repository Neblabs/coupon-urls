<?php

namespace CouponURLs\Original\Files;

use CouponURLs\Original\Abilities\FileReader;
use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Cache\Cache;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Environment\Env;
use Error;
use Exception;
use Throwable;
use function CouponURLs\Original\Utilities\Text\i;

class RequireFileReader implements FileReader
{
    public function __construct(
        protected Cache $cache = new MemoryCache
    ) {}
    
    public function read(ReadableFile $readableFile): mixed
    {
        return $this->cache->getIfExists('contents')->otherwise(
            function() use($readableFile) {
                try {
                    //php 72...
                    if (!file_exists($readableFile->source())) {
                        throw  new \Exception("File not found: {$readableFile->source()}");
                    }
                    return require $readableFile->source();
                } catch (Throwable $error) {
                    return require $this->relativePathLowercased($readableFile->source());
                }
            }
        );
    } 

    protected function relativePathLowercased(string $source) : string
    {
        // get the relative path 
        // lowercase it
        // then return the full path
        (string) $classNameWithNoMasterNamespace = substr(
            $source, 
            (strlen(Env::id()) + 1)
        );

        return strtolower(str_replace('\\', '/', $classNameWithNoMasterNamespace));
    }
    
}