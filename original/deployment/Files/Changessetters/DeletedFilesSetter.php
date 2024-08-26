<?php

namespace CouponURLS\Original\Deployment\Files\Changessetters;

use CouponURLS\Original\Deployment\Files\Files;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Executable\Abilities\Executable;

class DeletedFilesSetter implements Executable
{
    public function __construct(
        protected Files $files
    ) {}
    
    public function execute()
    {
        $this->files->allMirrorFiles()->forEvery(function(FileVersions $mirrorFileVersions) {
            // we're getting the "source" version of the mirror file
            if (!$mirrorFileVersions->source()->info()->isFile()) {
                $this->files->deleted->push($mirrorFileVersions);
            }
        }); 
    } 
}