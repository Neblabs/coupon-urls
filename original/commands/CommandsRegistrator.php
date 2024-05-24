<?php

namespace CouponURLs\Original\Commands;

use CouponURLs\Original\Environment\Env;
use Symfony\Component\Console\Application;

Class CommandsRegistrator
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->defaultCommands = (array) require Env::originalDirectory('commands') . 'register.php';
        $this->appCommands = (array) require Env::appDirectory('commands') . 'register.php';
    }

    public function register()
    {
        foreach ($this->getCommands() as $command) {
            $this->application->add(new $command);
        }
    }

    protected function getCommands()
    {
        return array_merge($this->appCommands, $this->defaultCommands);
    }

}