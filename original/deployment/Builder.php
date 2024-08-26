<?php

namespace CouponURLS\Original\Deployment;

use CouponURLS\Original\Deployment\SettingsReader;
use Symfony\Component\Console\Output\OutputInterface;

Class Builder
{
    protected $currentDirectory;

    public function __construct(OutputInterface $output)
    {
        $this->settingsReader = new SettingsReader;   
        $this->buildFileManager = new BuildFileManager($output);
        $this->currentDirectory = $this->buildFileManager->getCurrentDirectory();
    }

    public function build()
    {
        (string) $copyDirectoryName = $this->buildFileManager->createCopyDirectory();

        $this->buildFileManager->cloneDirectories($copyDirectoryName);
        $this->buildFileManager->compressCopy($copyDirectoryName);
        $this->buildFileManager->deleteCopiesDirectory($copyDirectoryName);
        
        $this->runScripts();
    }

    public function runScripts()
    {
        Script::handle($this->settingsReader->settings->scripts->afterCompression);
    }
    
}