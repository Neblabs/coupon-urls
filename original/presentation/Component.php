<?php

namespace CouponURLs\Original\Presentation;

use CouponURLs\Original\Environment\Env;
use ReflectionClass;

Class Component
{
    protected $file;

    public function render()
    {
        (object) $self = $this;

        include $this->templateFile();
    }

    public function getRenderedMarkup()
    {
        ob_start();

        $this->render();

        return ob_get_clean();
    }
    

    /*
        Overridable by children components
    */
    public function directory()
    {
        $rc = new ReflectionClass(get_class($this));
        
        return dirname($rc->getFileName());
        //return Env::directory() . 'app/views';
    }

    private function templateFile()
    {
        return "{$this->directory()}/".strtolower($this->file);
    }
}