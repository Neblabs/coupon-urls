<?php

namespace CouponURLS\Original\Deployment\Files;

use CouponURLS\Original\Cache\Cache;
use CouponURLS\Original\Cache\MemoryCache;
use CouponURLS\Original\Collections\Collection;
use CouponURLS\Original\Deployment\Directories\Directories;
use CouponURLS\Original\Deployment\Files\FileVersions;
use Symfony\Component\Finder\Finder;

use function CouponURLS\Original\Utilities\Collection\_;

class Files
{
    protected Cache $cache;

    public Collection $deleted;
    public Collection $changed;

    public function __construct(
        protected Finder $finder,
        protected object $buildSettings,
        protected Directories $directories,
        protected FileVersionsFactory $fileVersionsFactory
    ) {
        $this->cache = new MemoryCache;
        $this->deleted = _();
        $this->changed = _();
    }
    
    /**
     * These is every single file that will be copied including vendor files except for those
     * files that were explicitly marked as 'ignore' in the .build.php config file
     * 
     * @return Collection<\FileVersions>
     */
    public function allSourceFilesToCopy() : Collection
    {
        return $this->cache->getIfExists('all')->otherwise(function() {
            (object) $finder = $this->finder->files();

            //directories
            $finder->exclude(
                $this->buildSettings->directoriesToExclude->map(
                    function(string $fileToExclude) {
                        (string) $absoluteFileToExclude = "{$this->directories->source()}/{$fileToExclude}";

                        if (!file_exists($absoluteFileToExclude)) {
                            throw new \Exception("Nonexistent file to exclude: $absoluteFileToExclude");
                            
                        }

                        return $fileToExclude;
                    }
                )->asArray()
            );

            $finder->ignoreDotFiles($this->buildSettings->excludePrivateDirectories)
                   ->notName([
                        '*.phar',
                        '*.dist',
                        '*.DS_Store',
                        '*.sublime-project',
                        '*.sublime-workspace',
                        '*.bak',
                        '*.dist',
                        '*.phar',
                        '*.gz',
                        '*.DS_Store',
                        '*.sh',
                        '*.exe',
                        '*.php_cs.dist'
                   ])
                   ->in($this->directories->source());

            /**
             * @var Collection<FileVerions> $fileVersions
             */
            (object) $fileVersions = _();

            foreach ($finder as $file) {
                if ($this->buildSettings->filesToExclude->contain($file->getRelativePathname())) {
                    continue;
                }

                $fileVersions->push($this->fileVersionsFactory->createFromSource($file));
            }

            return $fileVersions;
        });
    }

    /**
     * Returns a new collection every time, so its immutable
     * 
     * @return Collection<FileVerions>
     */
    public function allMirrorFiles() : Collection
    {
        (object) $fileVersions = _();

        (object) $mirror = $this->cache->getIfExists('mirror')->otherwise(
            function() use($fileVersions) {
                /**
                 * @var Collection<FileVerions> $fileVersions
                 */
                foreach ($this->finder->files()->in($this->directories->mirror()) as $file) {
                    $fileVersions->push($this->fileVersionsFactory->createFromMirror($file));
                }
            }
        );

        return _($fileVersions);
    }

    public function haveChanged() : bool
    {
        return true /*$this->deleted->haveAny()*/;
    }
}