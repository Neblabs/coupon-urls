<?php

namespace CouponURLs\Original\Deployment;

use CouponURLs\Original\Collections\Collection;

Abstract Class Script
{
    protected $data;

    abstract public function run();

    public static function handle(Collection $scripts, array $data = [])
    {
        foreach ($scripts->asArray() as $scriptClass) {
            (object) $script = new $scriptClass($data);

            $script->run();

            exec('clear');
            //tprint method_exists($script, 'output')? $script->output(): "\nRunning script {$scriptClass}...\n";
        }
    }
    
    public function __construct($data = [])
    {
        $this->data = new Collection($data);
    }
}